<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MileageUnit extends Model
{
    use HasFactory;
    protected $table = 'ptw_mileage_units';
    public $primaryKey = 'mileage_unit_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function scopeActive($query){
        return $query->where('active',true);
    }
}
