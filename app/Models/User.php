<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "ptw_users";
    public $primaryKey = 'user_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'department_code',
        'last_updated_by',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'ptw_permission_user', 'user_id', 'permission_id');
    }

    public function assignPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function dismissPermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function hasPermission($permission){
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        if (get_class($permission) === 'App\Models\Permission') {
           return $this->permissions->contains($permission);
        }
        return !! $permission->intersect($this->permissions)->count();
    }
}
