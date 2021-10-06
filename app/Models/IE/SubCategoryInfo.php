<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryInfo extends Model
{
    use HasFactory;
    protected $table = 'ptw_sub_category_infos';
    public $primaryKey = 'sub_category_info_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function subCategory(){
        return $this->belongsTo('App\SubCategory','sub_category_id');
    }

    public function scopeActive($query){
        return $query->where('active', true);
    }

    public static function getlistFormTypes()
    {
        $lists = [
                    'text'      =>  'Text',
                    'select'    =>  'List of value',
                    'date'      =>  'Date picker'
                ];

        return $lists;
    }

    public function getInputFormValueAttribute()
    {
        if(!$this->form_value){ return ''; }

        if($this->form_type == 'date'){

            return dateFormatDisplay(implode(', ', json_decode($this->form_value)));

        }elseif($this->form_type == 'select'){

            $arrResult = [];
            $arrFormValue = json_decode($this->form_value);
            foreach ($arrFormValue as $key => $formValue) {
                $arrResult[$formValue] = $formValue;
            }

            return $arrResult;

        }else{ // text

            return implode(', ', json_decode($this->form_value));

        }
    }
}
