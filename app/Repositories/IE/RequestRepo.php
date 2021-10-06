<?php 

namespace App\Repositories\IE;

use App\Repositories\ApprovalRepo;
use App\Repositories\InterfaceRepo;

use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use App\Models\IE\Preference;
use App\Models\IE\SubCategory;
use App\Models\IE\InterfaceAP;


class RequestRepo
{
    public static function getPendingOverLimitDayRequest($userId)
    {
    	$result = [];
        return $result;
        $now = time(); // or your date as well
        $pendingDayBlocking = Preference::getPendingDayBlocking();

        // CASH ADVANCE PENDING
        $cashAdvances = CashAdvance::where('user_id',$userId)
        				->onApprovedNotCleared()
        				->get();
        foreach($cashAdvances as $ca){
            // GET DUE DATE AS START PENDING DAY COUNT
            $dueDate = strtotime($ca->due_date);
            $timeDiff = $now - $dueDate;
            $dateDiff =  floor($timeDiff / (60 * 60 * 24));
            if((int)$dateDiff >= (int)$pendingDayBlocking){
                array_push($result,["type"=>"App\CashAdvance", 
                                    "id"=>$ca->id,
                                    "document_no"=>$ca->document_no]);
            }
        }

		// REIMBURSE PENDING
		// $reims = Reimbursement::where('user_id',$userId)
        //       				->onPending()
        //       				->get();
        //       foreach($reims as $reim){
        //           $reimDate = strtotime($reim->created_at);
        //           $timeDiff = $now - $reimDate;
        //           $dateDiff =  floor($timeDiff / (60 * 60 * 24));
        //           if((int)$dateDiff >= (int)$pendingDayBlocking){
        //               array_push($result,["type"=>"App\Reimbursement", 
        //                                   "id"=>$reim->id,
        //                                   "document_no"=>$reim->document_no]);
        //           }
        //       }

        return $result;
    }

    public static function validateReceipt($parent)
    {
        $result = ['valid'=>true,'err_code'=>'','err_receipt_id'=>[],'err_msg'=>[]];
        if(!$parent){ 
            $result['valid'] = false;
            $result['err_code'] = 'not-found-parent';
        }else{
            // validate not found receipt
            if(count($parent->receipts) == 0){ 
                $result['valid'] = false;
                $result['err_code'] = 'not-found-receipt';
            }else{
                foreach ($parent->receipts as $receipt) {
                    // validate not found receipt line
                    if(count($receipt->lines) == 0){
                        array_push($result['err_receipt_id'], $receipt->id);
                        array_push($result['err_msg'], 'please enter receipt line.');
                    }else{
                        $taxFlag = 'N';
                        foreach($receipt->lines as $line){
                            // validate required attachment
                            if($line->subCategory->required_attachment){
                                if(count($receipt->attachments) == 0){
                                    if(!in_array($receipt->id, $result['err_receipt_id'])){
                                        array_push($result['err_receipt_id'], $receipt->id);
                                        array_push($result['err_msg'], 'required attachment.');
                                    }
                                }
                            }
                            if($line->vat_id){
                                $taxFlag = 'Y';
                            }
                        }
                        // validate required vendor if use vat in receipt line
                        if($taxFlag == 'Y'){
                            if($receipt->receiptable_type != 'App\Invoice'){
                                if(!$receipt->vendor_id){
                                    array_push($result['err_receipt_id'], $receipt->id);
                                    array_push($result['err_msg'], 'please enter vendor information.');
                                }
                            }
                        }
                        // validate total receipt must greater than zero
                        if((float)$receipt->total_amount <= 0){
                            array_push($result['err_receipt_id'], $receipt->id);
                            array_push($result['err_msg'], 'receipt amount must be greater than zero.');
                        }
                    }
                }
                if(count($result['err_receipt_id'])>0){
                    $result['valid'] = false;
                    $result['err_code'] = 'invalid-receipt';
                }
            }
        }
        
        return $result;
    }

    public static function combineReceiptGLCodeCombination($parent)
    {
        $result = ['status'=>'success','err_msg'=>'','err_receipt_line_id'=>null];
        $pointerReceiptLineId = null;
        try {
            if(count($parent->receipts)>0){
                foreach ($parent->receipts as $rcp_key => $receipt) {
                    if(count($receipt->lines)>0){
                        foreach ($receipt->lines as $l_key => $line) {
                            $pointerReceiptLineId = $line->id;
                            ///////////////////////////
                            // COMBINE GL ACCOUNT CODE
                            $lineSubCategory = SubCategory::find($line->sub_category_id);
                            $lineSegmants = InterfaceRepo::composeGLCodeCombinationSegments($line->branch_code,$line->department_code,$lineSubCategory->account_code,$lineSubCategory->sub_account_code,$receipt->project,$receipt->recharge);
                            $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($parent->user->employee,$lineSegmants);

                            $line->code_combination_id = $glCodeCombination['code_combination_id'];
                            $line->concatenated_segments = $glCodeCombination['concatenated_segments'];
                            $line->save();
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            // throw new \Exception($e->getMessage(), 1);
            $result = [ 'status'                =>  'error',
                        'err_msg'               =>  $e->getMessage(),
                        'err_receipt_line_id'   =>  $pointerReceiptLineId];
            return $result;
        }

        return $result;
    }

    public static function validateIsNotOverBudget($parent)
    {
        $result = ['valid'=>true,'arr_err_lines'=>[]];

        $arrAccount = [];

        // SUM TOTAL AMOUNT GROUP BY ACCOUNT (CODE COMBINATION ID)
        if(count($parent->receipts)>0){
            foreach ($parent->receipts as $rcp_key => $receipt) {
                if(count($receipt->lines)>0){
                    foreach ($receipt->lines as $l_key => $line) {
                        // IF FIRST TIME FOR THIS ACCOUNT (CODE COMBINATION ID)
                        if(!array_key_exists($line->code_combination_id, $arrAccount)){
                            $arrAccount[$line->code_combination_id]['code_combination_id'] = $line->code_combination_id;
                            $arrAccount[$line->code_combination_id]['concatenated_segments']  = $line->concatenated_segments;
                            // $arrAccount[$line->code_combination_id]['total_amount'] = (float)$line->total_primary_amount_inc_vat;
                            $arrAccount[$line->code_combination_id]['total_amount'] = (float)$line->total_primary_amount;
                            $arrAccount[$line->code_combination_id]['receipt_id'] = [];
                            $arrAccount[$line->code_combination_id]['receipt_line_id'] = [];
                            $arrAccount[$line->code_combination_id]['sub_category_id'] = [];
                            $arrAccount[$line->code_combination_id]['category_icon'] = [];
                            $arrAccount[$line->code_combination_id]['sub_category_name'] = [];
                        }else{ // IF ALREADY HAVE THIS ACCOUNT (CODE COMBINATION ID) => SUM FOR TOTAL
                            // $arrAccount[$line->code_combination_id]['total_amount'] += (float)$line->total_primary_amount_inc_vat;
                            $arrAccount[$line->code_combination_id]['total_amount'] += (float)$line->total_primary_amount;
                        }
                        // IF NOT HAVE THIS RECEIPT ON THIS ACCOUNT (CODE COMBINATION ID)
                        if(!in_array($receipt->id, $arrAccount[$line->code_combination_id]['receipt_id'])){
                            array_push($arrAccount[$line->code_combination_id]['receipt_id'], $receipt->id);
                        }
                        // IF NOT HAVE THIS RECEIPT LINE ON THIS ACCOUNT (CODE COMBINATION ID)
                        if(!in_array($line->id, $arrAccount[$line->code_combination_id]['receipt_line_id'])){
                            array_push($arrAccount[$line->code_combination_id]['receipt_line_id'], $line->id);
                        }
                        // IF NOT HAVE THIS SUB CATEGORY ON THIS ACCOUNT (CODE COMBINATION ID)
                        if(!in_array($line->sub_category_id, $arrAccount[$line->code_combination_id]['sub_category_id'])){
                            array_push($arrAccount[$line->code_combination_id]['sub_category_id'], $line->sub_category_id);
                            array_push($arrAccount[$line->code_combination_id]['category_icon'], $line->category->icon);
                            array_push($arrAccount[$line->code_combination_id]['sub_category_name'], $line->subCategory->name);
                        }
                    }
                }
            }
        }

        // CHECK OVER BUDGET BY TOTAL AMOUNT BY ACCOUNT (CODE COMBINATION ID)
        foreach ($arrAccount as $codeCombinationId => $account) {
            $overBudgetResult = InterfaceAP::getBudgetByAccount($parent->org_id,$account['concatenated_segments']);
            // CALL PACKAGE SUCCESS
            if($overBudgetResult['status'] == 'S'){
                $amountAvailable = (float)$overBudgetResult['fund_available'];
                // IF TOTAL AMOUNT > AMOUNT AVAILABLE
                if((float)$account['total_amount'] > $amountAvailable){
                    $arr_err_line['receipt_id'] = $account['receipt_id'];
                    $arr_err_line['receipt_line_id'] = $account['receipt_line_id'];
                    $arr_err_line['concatenated_segments'] = $account['concatenated_segments'];
                    $arr_err_line['category_icon'] = $account['category_icon'];
                    $arr_err_line['sub_category_name'] = $account['sub_category_name'];
                    $arr_err_line['total_amount'] = $account['total_amount'];
                    $arr_err_line['amount_available'] = $amountAvailable;
                    $arr_err_line['over_amount'] = abs((float)$account['total_amount'] - $amountAvailable);
                    $arr_err_line['err_msg'] = 'over budget';
                    array_push($result['arr_err_lines'], $arr_err_line);
                }
            }else{ // CALL PACKAGE ERROR
                throw new \Exception("Error : ".$overBudgetResult['err_msg'], 1);
            }
        }

        // IF FOUND ERROR LINE
        if(count($result['arr_err_lines']) > 0){
            $result['valid'] = false;
        }

        return $result;
    }

    public static function validateIsNotExceedPolicy($parent)
    {
        $result = ['valid'=>true,'arr_err_lines'=>[]];
        if(count($parent->receipts)>0){
            foreach ($parent->receipts as $rcp_key => $receipt) {
                if(count($receipt->lines)>0){
                    foreach ($receipt->lines as $l_key => $line) {
                        // IF USE POLICY
                        if($line->policy){

                            // USE POLICY EXPENSE
                            if($line->policy->typeExpense()){
                                // IF NOT UNLIMIT RATE
                                if(!$line->rate->unlimit){
                                    // COMPARE RATE WITH AMOUNT PER UNIT
                                    $policyRate = $line->rate->rate;
                                    $transactionQuantity = $line->transaction_quantity;
                                    // $totalAmount = $line->total_primary_amount_inc_vat;
                                    $totalAmount = $line->total_primary_amount;
                                    $amountPerUnit = (float)$totalAmount/(float)$transactionQuantity;
                                    // IF AMOUNT PER UNIT EXCEED POLICY
                                    if((float)$amountPerUnit > (float)$policyRate){
                                        $arr_err_line['receipt_id'] = $receipt->id;
                                        $arr_err_line['receipt_line_id'] = $line->id;
                                        if($line->subCategory->allow_exceed_policy){
                                            $arr_err_line['err_type'] = 'warning';
                                            $arr_err_line['err_msg'] = 'exceed policy';
                                        }else{
                                            $arr_err_line['err_type'] = 'error';
                                            $arr_err_line['err_msg'] = 'exceed policy';
                                        }
                                        array_push($result['arr_err_lines'], $arr_err_line);
                                    }
                                }

                            // USE POLICY MILEAGE
                            }elseif($line->policy->typeMileage()){
                                // IF NOT UNLIMIT RATE
                                if(!$line->rate->unlimit){
                                    // COMPARE MILEAGE RATE WITH AMOUNT PER UNIT
                                    $policyRate = $line->rate->rate;
                                    $mileageRate = (float)$line->rate->rate * (float)$line->mileage_distance;
                                    $transactionQuantity = $line->transaction_quantity; // NOW ALWAYS 1
                                    // $totalAmount = $line->total_primary_amount_inc_vat;
                                    $totalAmount = $line->total_primary_amount;
                                    $amountPerUnit = (float)$totalAmount/(float)$transactionQuantity;
                                    // IF AMOUNT PER UNIT EXCEED POLICY
                                    if((float)$amountPerUnit > (float)$mileageRate){
                                        $arr_err_line['receipt_id'] = $receipt->id;
                                        $arr_err_line['receipt_line_id'] = $line->id;
                                        if($line->subCategory->allow_exceed_policy){
                                            $arr_err_line['err_type'] = 'warning';
                                        }else{
                                            $arr_err_line['err_type'] = 'error';
                                        }
                                        $arr_err_line['err_msg'] = 'exceed policy';
                                        array_push($result['arr_err_lines'], $arr_err_line);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // IF FOUND ERROR LINE
        if(count($result['arr_err_lines']) > 0){
            $result['valid'] = false;
        }

        return $result;
    }

}
