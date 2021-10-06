<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;
    protected $table = 'ptw_categories';
    public $primaryKey = 'category_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'category_id');
    }

    public function scopeActive($query){
        return $query->where('active',true);
    }

    public function scopeAdvanceOver($query){
        return $query->where('name',config('services.category.advance_over_name'));
    }

    public function isAdvanceOver(){
        return $this->name == config('services.category.advance_over_name');
    }
}
