<?php

namespace App\Models\IE;

use \App\Models\IE\AccountInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FNDListOfValues extends Model
{
    use HasFactory;
    protected $table = 'ptie_fnd_lovs_v';

    public function scopeBranch($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT2',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeDepartment($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT3',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeAccount($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT6',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName)->where('summary_flag','N');
    }

    public function scopeSubAccount($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT7',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeProject($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT8',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeInterCompany($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT9',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeBySegment($query,$segmentNumber,$orgId = null)
    {
        $applicationColumnName = 'SEGMENT'.(string)$segmentNumber;
        $flexValueSetName = self::getFlexNameByAppColumnName($applicationColumnName,$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    public function scopeByApplicationColumnName($query,$applicationColumnName,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName($applicationColumnName,$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName);
    }

    // POSITION

    public function scopePoPositon($query,$orgId = null)
    {
        return $query->where('flex_value_set_name','TMITH_PO_POSITION')
                    ->where('summary_flag','N');
    }

    public function scopePoSection($query,$orgId = null)
    {
        return $query->where('flex_value_set_name','TMITH_PO_SECTION')
                    ->where('summary_flag','N');
    }

    public function scopePoLevel($query,$orgId = null)
    {
        return $query->where('flex_value_set_name','TMITH_PO_LEVEL')
                    ->where('summary_flag','N');
    }

    public function scopeByParentValue($query,$parentName,$parentValue)
    {
        if($parentName && $parentValue){
            return $query->where('parent_flex_value_set_name',$parentName)
                    ->where('parent_flex_value_low',$parentValue);
        }
        return ;
    }

    private static function getFlexNameByAppColumnName($applicationColumnName,$orgId)
    {
        if(!$orgId)
        // $orgId = \Auth::user()->employee->org_id;
        $orgId = 81;

        $accountInfo = AccountInfo::whereOrgId($orgId)
                        ->whereApplicationColumnName($applicationColumnName)
                        ->first();

        if(!$accountInfo)
        return ;

        return $accountInfo->flex_value_set_name;
    }
}
