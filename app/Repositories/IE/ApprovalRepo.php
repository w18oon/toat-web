<?php

namespace App\Repositories\IE;

use App\Repositories\RequestRepo;

use App\Approval;
use App\User;
use App\Employee;
use App\PositionInfo;
use App\POHierarchy;
use App\Job;
use App\Preference;

class ApprovalRepo
{
    public function approve($parent, $processType, $approverType, $userId = null)
    {
        if(!$userId)
        $userId = \Auth::user()->id;

        $approval = new Approval();
        $approval->user_id  = $userId;
        $approval->process_type = $processType;
        $approval->approver_type = $approverType;
        $lastApprover = self::getLastApprover($parent, $processType, $approverType);
        if($lastApprover){
            $approval->hierarchy_level = (int)$lastApprover->hierarchy_level + 1;
        }else{
            $approval->hierarchy_level = 1;
        }
        $parent->approvals()->save($approval);
    }

    public function reset($parent, $processType, $approverType = null)
    {
        $query = Approval::where('approvalable_id',$parent->id)
                        ->where('process_type',$processType);
        if($approverType){
            $query->where('approver_type',$approverType);
        }
        $approvals = $query->get();
        foreach($approvals as $approval){
            $approval->delete();
        }
    }

    public static function getNextApprover($parent,$processType)
    {
        $amount = 0;
        // RETURN ARRAY NULL IF NOT HAVE HIGHER LEVEL APPROVER
        $result = [];

        // POSITION VERSION NUMBER
        $versionNumber = PositionInfo::getPositionLastVersionNumber();

        ////////////////
        // CASH ADVANCE
        if($processType == 'CASH-ADVANCE')
        $amount = $parent->amount + 0;

        ////////////////////////////////////////
        // REIMBURSEMENT or CLEARING or INVOICE
        if($processType == 'REIMBURSEMENT' || $processType == 'CLEARING' || $processType == 'INVOICE')
        $amount = $parent->total_receipt_amount + 0;

        $approvers = Approval::where('approvalable_id',$parent->id)
                ->where('process_type',$processType)
                ->where('approver_type','APPROVER')
                ->get();

        //////////////////////////////////////////////////////////////////////////////
        // IF NOT HAVE RECENT APPROVER
        //       SUBORDINATE    = REQUESTER,
        //       NEXT APPROVER  = PARENT POSITION OF REQUESTER

        if(count($approvers) == 0){

            // SUBORDINATE POSITION INFO = REQUESTER POSITION WHEN CREATE REQUEST
            $subordinatePositionId = $parent->user->employee->position_id;
            $subordinatePositionInfo = PositionInfo::expensePosition($versionNumber)->where('parent_pos_id',$parent->user->employee->position_id)->first();

        } else {

        //////////////////////////////////////////////////////////////////////////////
        // IF HAVE RECENT APPROVER
        //        SUBORDINATE     = LAST APPROVER,
        //        NEXT APPROVER   = PARENT POSITION OF LAST APPROVER

            $subordinate = self::getLastApprover($parent, $processType, 'APPROVER');
            if($subordinate->user){
                if($subordinate->user->employee){
                    if(!$subordinate->user->employee->position_id){
                        throw new \Exception("Error : Not found subordinate position data, please contact administrator to solve this issue.", 1);
                    }

                    // GET SUBORDINATE POSITION INFO
                    $subordinatePositionId = $subordinate->user->employee->position_id;
                    $subordinatePositionInfo = PositionInfo::expensePosition($versionNumber)->where('parent_pos_id',$subordinate->user->employee->position_id)->first();

                }else{
                    throw new \Exception("Error : Not found subordinate employee data, please contact administrator to solve this issue.", 1);
                }
            }else{
                throw new \Exception("Error : Not found subordinate user data, please contact administrator to solve this issue.", 1);
            }
        }

        /////////////////////////////////////////
        // VALIDATE TOP HIERARCHY LIMIT AMOUNT //
        // ** amount request must not over top hierarchy limit amount **
        self::validateTopHierarchyLimitAmount($amount,$versionNumber,$subordinatePositionId,$parent->org_id);

        /////////////////////////////////////////////
        // CHECK AMOUNT (LIMIT AMOUNT & OVER BUDGET)

        // IF NOT FOUND POSITION INFO (AMOUNT LIMIT = 0)
        if(!$subordinatePositionInfo){
            $nextApproverPOHierarchy = POHierarchy::expenseHierarchy()->where('subordinate_position_id',$subordinatePositionId)->first();
        }else{

            // CASH ADVANCE NOT CHECK OVER BUDGET
            if($processType == 'CASH-ADVANCE'){
                $overBudget = false;
            }else{ // REIMBURSEMENT & CLEARING & INVOICE
                $overBudget = $parent->over_budget;
            }

            ///////////////////////////////////////////////////////////////////////////////////////////
            // OVER BUDGET // => CHECK OVER-BUDGET APPROVER JOB AUTHORITY & CHECK LIMIT AMOUNT
            if($overBudget){

                $overBudgetApproverJob = Preference::getOverBudgetApproverJob($parent->orgId);
                $overBudgetApproverJobData = Job::where('job_id',$overBudgetApproverJob)->first();
                $overBudgetApproverJobAuthority = $overBudgetApproverJobData->approval_authority;

                $subordinateAuthority = $subordinatePositionInfo->parent_approval_authority;

                // IF SUBORDINATE JOB AUTHORITY LOWER THAN OVER-BUDGET JOB AUTHORITY
                // => NEED NEXT APPROVAL
                if((float)$subordinateAuthority < (float)$overBudgetApproverJobAuthority){

                    $nextApproverPOHierarchy = POHierarchy::expenseHierarchy()->where('subordinate_position_id',$subordinatePositionId)->first();

                }else{

                // IF SUBORDINATE JOB AUTHORITY HIGHER THAN OR EQUAL OVER-BUDGET JOB AUTHORITY
                // => CHECK LIMIT AMOUNT

                    // IF LIMIT AMOUNT NOT ENOUGH => NEED NEXT APPROVER
                    if($subordinatePositionInfo->parent_amount_limit < $amount){
                        $nextApproverPOHierarchy = POHierarchy::expenseHierarchy()->where('subordinate_position_id',$subordinatePositionId)->first();
                    }else{
                        // IF FOUND POSITION INFO BUT AMOUNT ENOUGH => NOT HAVE NEXT APPROVER
                        $nextApproverPOHierarchy = null;
                    }
                }

            }else{

            //////////////////////////////////////////////
            // NOT OVER BUDGET // => CHECK LIMIT AMOUNT

                // IF LIMIT AMOUNT NOT ENOUGH => NEED TO HAVE NEXT APPROVER
                if($subordinatePositionInfo->parent_amount_limit < $amount){
                    $nextApproverPOHierarchy = POHierarchy::expenseHierarchy()->where('subordinate_position_id',$subordinatePositionId)->first();
                }else{
                    // IF FOUND POSITION INFO BUT AMOUNT ENOUGH => NOT HAVE NEXT APPROVER
                    $nextApproverPOHierarchy = null;
                }

            }
        }

        // IF FOUND PARENT POSITION
        if($nextApproverPOHierarchy){

            // GET ORACLE EMPLOYEE DATA
            $nextApproverEmployee = Employee::where('position_id',$nextApproverPOHierarchy->parent_position_id)->first();

            // IF FOUND NEXT APPROVER
            if($nextApproverEmployee){
                // GET USER WEB DATA
                $nextApprover = User::findByOraclePersonId($nextApproverEmployee->person_id);
                if($nextApprover){
                    $result = ['user_id' => $nextApprover->id];
                }else{ // IF HAVE NEXT APPROVER BUT NOT FOUND DATA IN ORACLE EMPLOYEE
                    throw new \Exception("Error : Not found next approver user data ( position \"".$nextApproverPOHierarchy->parent_name."\" ), please contact administrator to solve this issue.", 1);
                }
            }else{
                // IF NOT FOUND PARENT POSITION EMPLOYEE DATA
                throw new \Exception("Error : Not found next approver user data ( position \"".$nextApproverPOHierarchy->parent_name."\" ), please contact administrator to solve this issue.", 1);
            }

        }else{

        // IF NOT FOUND PARENT POSITION

            $subordinateAmountLimit = 0;
            if($subordinatePositionInfo){
                $subordinateAmountLimit = $subordinatePositionInfo->parent_amount_limit;
            }
            // IF NOT FOUND PARENT POSITION AND SUBORDINATE POSITION LIMIT AMOUNT NOT ENOUGH
            // => NOT ALLOW TO SEND REQUEST
            // ** case user not have boss and request over user limit amount **
            if($subordinateAmountLimit < $amount){
                throw new \Exception("Error : Not found parent position hierarchy data for approval, please contact administrator to solve this issue.", 1);
            }
        }

        return $result;
    }

    public static function getRelatedApprovers($parent,$processType,$approverType)
    {
        $query = Approval::where('approvalable_id',$parent->id)
                        ->where('process_type',$processType);
        if($approverType){
            $query->where('approver_type',$approverType);
        }
        $approvalUserIds = $query->pluck('user_id');
        if(count($approvalUserIds)>0){
            return User::whereIn('id',$approvalUserIds)->get();
        }else{
            return ;
        }
    }

    public static function validateTopHierarchyLimitAmount($amount,$versionNumber,$subordinatePositionId,$orgId)
    {
        // IF NOT FOUND SUBORDINATE AS PARENT POSITION HIERARCHY => IS BOTTOM CHILD POSITION HIERARCHY
        $topHierarchy = POHierarchy::getTopApprovalLimitAmount(POHierarchy::getApprovalHierarchyName(),POHierarchy::getApprovalControlFunctionName(),$versionNumber,$subordinatePositionId,$orgId);
        if($topHierarchy['status'] == 'E'){
            throw new \Exception("Error : ".$topHierarchy['err_msg'].", please contact administrator to solve this issue.", 1);
        }
        $topPositionId = $topHierarchy['max_position_id'];

        $topHierarchyPositionInfo = PositionInfo::expensePosition($versionNumber)->where('parent_pos_id',$topPositionId)->first();

        // IF AMOUNT REQUEST MORE THAN TOP HIERARCHY LIMIT AMOUNT => NOT ALLOW TO REQUEST
        if((float)$amount > (float)$topHierarchyPositionInfo->parent_amount_limit){
            throw new \Exception("Error : Amount request (".number_format($amount,2).") is over top hierarchy position limit amount (".number_format($topHierarchyPositionInfo->parent_amount_limit,2)."), please contact administrator to solve this issue.", 1);
        }
    }

    public static function getLastApprover($parent, $processType, $approverType = null)
    {
        $query = Approval::where('approvalable_id',$parent->id)
                        ->where('process_type',$processType);
        if($approverType){
            $query->where('approver_type',$approverType);
        }
        $approvals = $query->get();
        if(count($approvals) > 0){
            $lastApprover = $approvals->sortByDesc('hierarchy_level')->values()->first();
            return $lastApprover;
        }else{
            return ;
        }
    }

}
