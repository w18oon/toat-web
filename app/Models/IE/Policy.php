<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;
    protected $table = 'ptw_policies';
    public $primaryKey = 'policy_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    protected $fillable = ['org_id','category_id','sub_category_id','type'];

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function subCategory(){
        return $this->belongsTo('App\SubCategory','sub_category_id');
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public function typeExpense(){
        return $this->type == 'EXPENSE';
    }

    public function typeMileage(){
        return $this->type == 'MILEAGE';
    }
}
