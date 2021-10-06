<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'ptw_permissions';
    public $primaryKey = 'permission_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];


    public function menu()
    {
        return $this->hasOne(Menu::class, 'menu_id', 'menu_id');
    }
}
