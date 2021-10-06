<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRate extends Model
{
    use HasFactory;
    protected $table = 'ptw_policy_rates';
    public $primaryKey = 'policy_rate_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    protected $fillable = [ 'org_id',
                            'category_id',
                            'sub_category_id',
                            'policy_id',
                            'last_updated_by',
                            'created_by',
                            'position_po_level', // null = any
                            'location_id']; // null = any

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function subCategory(){
        return $this->belongsTo('App\SubCategory','sub_category_id');
    }

    public function policy(){
        return $this->belongsTo('App\Policy','policy_id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public function getRateValueAttribute()
    {
        if($this->unlimit){
            return 'Unlimit';
        }else{
            return $this->rate ? $this->rate : 0;
        }
    }

    public static function getRateByCondition($policyId, $positionPoLevel = null, $locationId = null)
    {
        // BY POSITION & LOCATION
        if($positionPoLevel && $locationId){
            $rate = self::where('policy_id', $policyId)
                        ->where('position_po_level', $positionPoLevel)
                        ->where('location_id', $locationId)
                        ->first();
            if($rate){ return $rate; }
        }
        // BY POSITION
        if($positionPoLevel){
            $rate = self::where('policy_id', $policyId)
                        ->where('position_po_level', $positionPoLevel)
                        ->whereNull('location_id')
                        ->first();
            if($rate){ return $rate; }
        }
        // BY LOCATION
        if($locationId){
            $rate = self::where('policy_id', $policyId)
                        ->whereNull('position_po_level')
                        ->where('location_id', $locationId)
                        ->first();
            if($rate){ return $rate; }
        }
        // ANY CASE (ALWAYS DEFAULT WHEN ENABLE USE POLICY)
        $rate = self::where('policy_id', $policyId)
                        ->whereNull('position_po_level')
                        ->whereNull('location_id')
                        ->first();
        return $rate;
    }
}
