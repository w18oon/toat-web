<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = "ptw_menus";
    public $primaryKey = 'menu_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'menu_title',
        'parent_id',
        'sort_order',
        'url',
        'permission_code',
        'server_id',
        'program_code',
        'last_updated_by',
        'created_by',
    ];


    public function parent()
    {
        return $this->hasOne('App\Models\Menu', 'menu_id', 'parent_id')->orderBy('sort_order');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'menu_id')->orderBy('sort_order');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'menu_id', 'menu_id');
    }

    public function programInfo()
    {
        return $this->hasOne(ProgramInfo::class, 'program_code', 'program_code');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getParentFormatAttribute()
    {
        $format = '';
        $parent = $this->parent;
        $parentSecond = optional($parent)->parent;

        if ($parentSecond) {
            $format .= $parentSecond->menu_title . ", ";
        }

        if ($parent) {
            $format .= $parent->menu_title . "";
        }

        return $format;
    }

    public static function tree($serverId = false, $userId = false)
    {
        $user = false;
        if ($userId) {
            $user = \App\Models\User::find($userId);
        }
        $arrMenu = [];
        if ($user && $user->permissions) {
            $arrMenu = $user->permissions->pluck('menu_id', 'menu_id')->all();
        }


        return static::with([
                        'children' => function ($query) use($arrMenu) {
                            $query->whereIn('menu_id', $arrMenu);
                        },
                        'children.children' => function ($query) use($arrMenu) {
                            $query->whereIn('menu_id', $arrMenu);
                        }
                    ])
                    ->active()
                    ->where('parent_id', '=', '0')
                    ->when($serverId, function($q) use($serverId) {
                        $q->where('server_id', $serverId);
                    })
                    ->when($user, function($q) use($user, $arrMenu) {
                        $q->whereIn('menu_id', $arrMenu);
                    })
                    ->orderBy('sort_order')->get();
    }

    public static function treeAll($onlyActive = false)
    {
        // dd('xx', implode('.', array_fill(0, 2, 'children.programInfo')));
        return static::with(implode('.', array_fill(0, 100, 'children')) )
                    // ->whereIn('menu_id', $arrMenu)
                    // ->active()
                    ->when($onlyActive, function($q) {
                        $q->active();
                    })
                    ->where('parent_id', '=', '0')
                    ->orderBy('sort_order')->get();
    }
}
