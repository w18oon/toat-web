<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AccessibleOrg extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ptw_accessible_orgs';
    public $primaryKey = 'accessible_org_id';
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function accessibleOrgable()
    {
        return $this->morphTo();
    }
}
