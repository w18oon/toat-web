<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = "ptw_locations";
    public $primaryKey = 'location_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function accessibleOrgs()
    {
        return $this->morphMany(AccessibleOrg::class, 'accessible_orgable');
    }

    public function scopeAccessibleOrg($query, $orgId = null){
        if(!$orgId)
        $orgId = \Auth::user()->org_id;

        return $query->whereHas('accessibleOrgs', function ($query1) use ($orgId) {
            $query1->where('org_id', $orgId);
        });
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }
}
