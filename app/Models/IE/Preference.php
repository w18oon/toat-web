<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'ptw_preferences';
    public $primaryKey = 'preference_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    protected $fillable = ['org_id','category_id','sub_category_id','type'];

    public static function getBaseCurrency()
    {
        // if(!$orgId)
        // $orgId = \Auth::user()->org_id;

        $currency = Currency::whereCurrencyCode('THB')->first();

        if($currency){
            return $currency->currency_code;
        }else{
            return 'THB'; // default THB
        }
    }

    public static function getBaseMileageUnit()
    {
        // if(!$orgId)
        // $orgId = \Auth::user()->org_id;

        $mileageUnit = MileageUnit::whereCode('KM')->first();

        return $mileageUnit->mileage_unit_id;
    }

    public static function getPendingDayBlocking()
    {
        // if(!$orgId)
        // $orgId = \Auth::user()->org_id;

        $pendingDayBlocking = self::whereCode('pending_day_blocking')
                            ->first();
        // default if not found
        if(!$pendingDayBlocking){
            $pendingDayBlocking = new Preference();
            $pendingDayBlocking->code = 'pending_day_blocking';
            // $pendingDayBlocking->org_id = $orgId;
            $pendingDayBlocking->data_type = 'varchar';
            $pendingDayBlocking->data_value = '["0"]';
            $pendingDayBlocking->save();
        }
        return decodeDataValue($pendingDayBlocking->data_type,
                                        $pendingDayBlocking->data_value);
    }

    public static function getUnblockers()
    {
        // if(!$orgId)
        // $orgId = \Auth::user()->org_id;

        $unblockUsers = self::whereCode('unblock_users')
                            ->first();
        // default if not found
        if(!$unblockUsers){
            $unblockUsers = new Preference();
            $unblockUsers->code = 'unblock_users';
            // $unblockUsers->org_id = $orgId;
            $unblockUsers->data_type = 'json';
            $unblockUsers->data_value = null;
            $unblockUsers->save();
        }

        return decodeDataValue($unblockUsers->data_type,
                                        $unblockUsers->data_value);

    }

    public static function getOverBudgetApproverJob()
    {
        // if(!$orgId)
        // $orgId = \Auth::user()->org_id;

        $overBudgetApproverJob = self::whereCode('over_budget_approver_job')
                            ->first();
        // default if not found
        if(!$overBudgetApproverJob){
            // DEFAULT APPROVAL AUTHORITY = 60 (EO)
            $jobEO = Job::where('approval_authority',60)->first();
            $overBudgetApproverJob = new Preference();
            $overBudgetApproverJob->code = 'over_budget_approver_job';
            // $overBudgetApproverJob->org_id = $orgId;
            $overBudgetApproverJob->data_type = 'varchar';
            $overBudgetApproverJob->data_value = '["'.$jobEO->job_id.'"]';
            $overBudgetApproverJob->save();
        }
        return decodeDataValue($overBudgetApproverJob->data_type,
                                        $overBudgetApproverJob->data_value);
    }
}
