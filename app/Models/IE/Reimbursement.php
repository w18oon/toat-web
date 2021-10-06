<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    use HasFactory;
    protected $table = 'ptw_reimbursements';
    public $primaryKey = 'reimbursement_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    // ===========================
    // === REIMBURSEMENT STATUS ===
    // ===========================
    // ['NEW_REQUEST',
    //  'BLOCKED',
    //  'APPROVER_DECISION',
    //  'APPROVER_REJECTED',
    //  'APPROVED',
    //  'CANCELLED'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    // Approver who was assigned
    public function approver(){
        return $this->belongsTo('App\User','next_approver_id');
    }

    public function approvals()
    {
        return $this->morphMany('App\Approval', 'approvalable')->with('user');
    }

    public function receipts()
    {
        return $this->morphMany('App\Receipt', 'receiptable')->orderBy('created_at');
    }

    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachmentable');
    }

    public function activityLogs()
    {
        return $this->morphMany('App\ActivityLog', 'activity_logable')->orderBy('created_at','desc')->with('user');
    }

    public function getTotalReceiptTaxAttribute()
    {
        $totalTax = 0;
        foreach($this->receipts as $receipt){
            $totalTax += $receipt->lines->sum('primary_vat_amount');
            // $totalTax += $receipt->lines->sum('primary_wht_amount');
        }
        return $totalTax;
    }

    public function getTotalReceiptAmountBeforeTaxAttribute()
    {
        $totalReceiptAmountBeforeTax = 0;
        foreach($this->receipts as $receipt){
            $totalReceiptAmountBeforeTax += $receipt->lines->sum('total_primary_amount');
        }
        return $totalReceiptAmountBeforeTax;
    }

    public function getTotalReceiptAmountAttribute()
    {
        $totalAmount = 0;
        foreach($this->receipts as $receipt){
            $totalAmount += $receipt->lines->sum('total_primary_amount_inc_vat');
        }
        return $totalAmount;
    }

    public static function genDocumentNo($orgId)
    {
        $year = date('y');

        // END DO WHILE WHEN NOT FOUND REIM NUMBER AS INVOICE IN ERP SYSTEM
        do {

            $runningTranId = \App\TransactionSequence::getTranID($orgId,'App\Reimbursement',$year);
            $reimDocNo = 'RE' . $year . str_pad($runningTranId, 6, '0', STR_PAD_LEFT);

        } while(self::checkDupInvNo($orgId,$reimDocNo));

        $result = $reimDocNo;

        return $result;
    }

    private static function checkDupInvNo($orgId,$reimDocNo)
    {
        // IF FOUND THIS CA NUMBER OR CC NUMBER
        return false;
    }

    public function scopeSearch($query,$search,$search_date = null)
    {
        $query->where(function($query) use ($search){
            foreach ($search as $key => $value) {
              if ($value) {
                if ($key == 'document_no') {
                  $query->where($key, 'LIKE',  '%' . $value . '%');
                }else{
                  $query->where($key, '=',  $value);
                }
              }
            }
        });

        if($search_date){
            if (array_key_exists("date_from",$search_date)){
                if($search_date['date_from']){
                    $from_date = DateTime::createFromFormat(trans('date.format'), $search_date['date_from'])->format('Y-m-d');
                    $query->where('created_at', '>=' ,$from_date) ;
                }
            }
            if (array_key_exists("date_to",$search_date)){
                if($search_date['date_to']){
                    $to_date = DateTime::createFromFormat(trans('date.format'), $search_date['date_to'])->format('Y-m-d');
                    $query->where('created_at', '<=' ,$to_date) ;
                }
            }
        }
        return $query;
    }

    public function scopeOnPending($query){
        return $query->whereNotIn('status',['BLOCKED','APPROVER_REJECTED','APPROVED','CANCELLED']);
    }

    public function scopeByKeyword($query,$keyword)
    {
        if($keyword){
            $query->where('document_no', 'like' ,'%'.$keyword.'%')
                ->orWhere('status', 'like' ,'%'.$keyword.'%')
                ->orWhere(function ($query) use ($keyword) {
                    $query->whereHas('user', function($query) use ($keyword){
                        $query->where('name', 'like' ,'%'.$keyword.'%');
                    });
                })
                ->orWhere(function ($query) use ($keyword) {
                    $query->whereHas('approver', function($query) use ($keyword){
                        $query->where('name', 'like' ,'%'.$keyword.'%');
                    });
                });
        }
        return $query;
    }

    public function scopeByYearShowing($query,$yearShowing)
    {
        if($yearShowing){
            $from_date = $yearShowing.'-01-01 00:00:00';
            $to_date = $yearShowing.'-12-31 23:59:59';
            $query->where('created_at', '>=' ,$from_date);
            $query->where('created_at', '<=' ,$to_date);
        }
        return $query;
    }

    public function scopeByRelatedUser($query,$userId = null)
    {
        // GET USER DATA
        if(!$userId){
            $user = \Auth::user();
            $userId = $user->id;
        }else{
            $user = \App\User::find($userId);
        }

        // ADMIN & FINANCE WILL SEE ALL CASH-ADVANCE
        if(!$user->isAdmin() && !$user->isFinance()){

            // IS REQUESTER
            $query->where('user_id', $userId);

            // // IS NEXT APPROVER
            // $query->orWhere('next_approver_id', $userId);
            // // IS RECENT APPROVAL
            // $query->orWhere(function ($query) use ($userId) {
            //     $query->whereHas('approvals', function($query) use ($userId){
            //         $query->where('user_id',$userId);
            //     });
            // });

            // GET SUBORDINATE PERSON FROM PO HIERARCHY
            $subordinatePersons = \App\POHierarchy::findAllChildByParent($user->employee->person_id,$user->employee->position_id);

            // IS HIGHER LEVEL IN POSITION HIERACHY
            if(count($subordinatePersons) > 0){
                $chunkSubordinatePersons = $subordinatePersons->chunk(500);
                $query->orWhere(function ($query) use ($chunkSubordinatePersons) {
                    $query->whereHas('user', function($query) use ($chunkSubordinatePersons){
                        foreach ($chunkSubordinatePersons as $key => $chunkSubordinatePerson) {
                            if($key == 0){
                                $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
                            }else{
                                $query->orWhere(function ($query) use ($chunkSubordinatePerson) {
                                    $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
                                });
                            }
                        }
                    });
                });
            }
        }
        return $query;
    }

    public function scopeByPendingUser($query,$userId)
    {
        // GET USER DATA
        $user = \App\User::find($userId);
        // REQUESTER
        $query->where(function ($query) use ($userId) {
            $query->whereIn('status', ['NEW_REQUEST'])
                  ->where('user_id', $userId);
        });
        if($user->isUnblocker()){
            // IF IS UNBLOCKER USER SHOW ALL REIM STATUS BLOCKED
            $query->orWhere('status', 'BLOCKED');
        }else{
            // IF NOT UNBLOKER SHOW ONLY HIS BLOCKED REQUEST
            $query->orWhere(function ($query) use ($userId) {
                $query->where('status', 'BLOCKED')
                      ->where('user_id', $userId);
            });
        }
        // APPROVER
        $query->orWhere(function ($query) use ($userId) {

             $query->whereIn('status', ['APPROVER_DECISION'])
                  ->where('next_approver_id', $userId);

        });

        return $query;
    }

    public function getPendingUserAttribute()
    {
        if($this->status == 'NEW_REQUEST' ||
            $this->status == 'BLOCKED'){

            $result = $this->user->name;

        }elseif($this->status == 'APPROVER_DECISION'){

            $result = $this->approver ? $this->approver->name : '-';

        }else{
            $result = '-';
        }

        return $result;
    }

    public function getNextApproverAttribute()
    {
        $result = null;
        if($this->status == 'APPROVER_DECISION'){

            $result = $this->approver ? $this->approver->name : '-';

        }
        return $result;
    }

    public function isRequester($userId = null)
    {
        if(!$userId)
        $userId = \Auth::user()->id;

        return $this->user_id == $userId;
    }

    public function isNextApprover($userId = null)
    {
        if(!$userId)
        $userId = \Auth::user()->id;

        return $this->next_approver_id == $userId;
    }

    public function isRelatedUser($userId = null)
    {
        // GET USER DATA
        if(!$userId){
            $user = \Auth::user();
            $userId = $user->id;
        }else{
            $user = \App\User::find($userId);
        }

        // ADMIN & FINANCE WILL SEE ALL CASH-ADVANCE
        if($user->isAdmin() || $user->isFinance()){
            $permit = true;
        }else{

            // IS REQUESTER
            $query = self::where('user_id', $userId);

            // // IS NEXT APPROVER
            // $query->orWhere('next_approver_id', $userId);
            // // IS RECENT APPROVAL
            // $query->orWhere(function ($query) use ($userId) {
            //     $query->whereHas('approvals', function($query) use ($userId){
            //         $query->where('user_id',$userId);
            //     });
            // });

            // GET SUBORDINATE PERSON FROM PO HIERARCHY
            $subordinatePersons = \App\POHierarchy::findAllChildByParent($user->employee->person_id,$user->employee->position_id);
            // IS HIGHER LEVEL IN POSITION HIERACHY
            if(count($subordinatePersons) > 0){
                $chunkSubordinatePersons = $subordinatePersons->chunk(500);
                $query->orWhere(function ($query) use ($chunkSubordinatePersons) {
                    $query->whereHas('user', function($query) use ($chunkSubordinatePersons){
                        foreach ($chunkSubordinatePersons as $key => $chunkSubordinatePerson) {
                            if($key == 0){
                                $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
                            }else{
                                $query->orWhere(function ($query) use ($chunkSubordinatePerson) {
                                    $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
                                });
                            }
                        }
                    });
                });
            }

            $permit = !! $query->first();
        }
        return $permit;
    }

    public function isNotLock()
    {
        // NOT LOCK ON STATUS 'NEW_REQUEST','BLOCKED'
        return ($this->status == 'NEW_REQUEST' || $this->status == 'BLOCKED');
    }

    public function isPendingReceipt(){
        return ($this->status == 'NEW_REQUEST' || $this->status == 'BLOCKED');
    }
}
