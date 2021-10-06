<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;
use App\Models\Server;
use App\Models\Permission;
use App\Models\ProgramInfo;

class MenuController extends Controller
{
    public function index()
    {
        $menuTreeAll = (new Menu)->treeAll();
        return view('menus.index', compact('menuTreeAll'));
    }

    public function create()
    {
        $menu = new Menu;
        $programCode = $this->getPorgramInfoInput();
        $servers = Server::get()->pluck('description', 'server_id')->all();
        $parentMenus = Menu::orderByRaw('parent_id, sort_order')->get();
        if (count($parentMenus) == 0) {
            $parentMenus = [];
        } else {
            $parentMenus = $parentMenus->pluck('menu_title', 'menu_id')->all();
        }

        return view('menus.create', compact('menu', 'parentMenus', 'servers', 'programCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'menu_title' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            $user = auth()->user();
            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['last_updated_by'] = optional($user)->user_id ?? -1;
            $input['created_by'] = optional($user)->user_id ?? -1;

            $menu = Menu::create($input);

            $permEnter = new Permission;
            $permEnter->name = $menu->permission_code . '_ENTER';
            $permView = new Permission;
            $permView->name = $menu->permission_code . '_VIEW';
            $menu->permissions()->save($permEnter);
            $menu->permissions()->save($permView);

            \DB::commit();
            return back()->with('success', 'Menu added successfully.');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function edit(Menu $menu)
    {
        $programCode = $this->getPorgramInfoInput();
        $servers = Server::get()->pluck('description', 'server_id')->all();
        $parentMenus = Menu::orderByRaw('parent_id, sort_order')->get();
        if (count($parentMenus) == 0) {
            $parentMenus = [];
        } else {
            $parentMenus = $parentMenus->pluck('menu_title', 'menu_id')->all();
        }

        return view('menus.edit', compact('menu', 'parentMenus', 'servers', 'programCode'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
           'menu_title' => 'required',
        ]);

        try {
            \DB::beginTransaction();
            $user = auth()->user();

            $menu->parent_id = request()->parent_id ?? 0;
            $menu->permission_code = request()->permission_code;
            $menu->menu_title = request()->menu_title;
            $menu->sort_order = request()->sort_order;
            $menu->url = request()->url;
            $menu->server_id = request()->server_id;
            $menu->program_code = request()->program_code;
            $menu->last_updated_by = optional($user)->user_id ?? -1;
            $menu->save();


            $permEnter = $menu->permissions()->where("name", 'like', "%_ENTER")->first();
            $permEnter->name = $menu->permission_code . '_ENTER';
            $permEnter->save();

            $permView = $menu->permissions()->where("name", 'like', "%_VIEW")->first();
            $permView->name = $menu->permission_code . '_VIEW';
            $permView->save();

            \DB::commit();
            return redirect()->route('menus.index')->with('success', 'Menu added successfully.');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }


    public function show()
    {
        $menus = Menu::active()->where('parent_id', '=', 0)->get();
        $menuList = $menu->tree();

        return view('menus.dynamicMenu',compact('menuList'));
    }


    private function getPorgramInfoInput()
    {
        $data = ProgramInfo::selectRaw("program_code ||': '|| description as description, program_code")
                ->orderBy('program_code')
                ->get();
        if (count($data) == 0) {
            return [];
        } else {
            return  $data->pluck('description', 'program_code')->all();
        }
    }
}
