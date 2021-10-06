<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Permission;
use App\Http\Requests\User\StoreUserRequest;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $orgId;
    protected $perPage = 20;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->search ?? [];
        $users = User::orderBy('name')
                    ->paginate($this->perPage);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        return view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $data = $request->validated();
        $data['password'] = bcrypt($request->password ?? '11111111');
        $data['last_updated_by'] = $userId;
        $data['created_by'] = $userId;


        User::create($data);

        return redirect()->route('users.index')->with('success','ทำการเพิ่มสมาชิกในระบบเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, User $user)
    {
        try {
            \DB::beginTransaction();

            $userId = optional(auth()->user())->user_id ?? -1;
            $user->name = $request->name;
            $user->department_code = $request->department_code;
            $user->last_updated_by = $userId;
            $user->last_update_date = now();
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            \DB::commit();
            return redirect()->route('users.index')->with('success', 'ทำการอัพเดตสมาชิกในระบบเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            \DB::beginTransaction();

            $user->delete();

            // $userId = optional(auth()->user())->user_id ?? -1;
            // $user->last_updated_by = $userId;
            // $user->last_update_date = now();
            // $user->save();

            \DB::commit();
            return redirect()->route('users.index')->with('success', 'ทำการลบสมาชิกในระบบเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
        //
    }

    public function permissions(User $user)
    {
        $menu = new Menu;
        $menuList = $menu->treeAll($onlyActive = true);

        return view('users.permissions', compact('user', 'menuList'));
    }

    public function assignPermission(User $user)
    {
        $permission = Permission::find(request()->permission_id);
        if(request()->is_checked === 'true' && !$user->hasPermission($permission)){
            $user->assignPermission($permission);
        }elseif(request()->is_checked === 'false' && $user->hasPermission($permission)) {
            $user->dismissPermission($permission);
        }


        // Assign, Dismiss Permission Parent
        $menuParent = $permission->menu->parent;
        $nextParent = $this->adjParentMenu($user, $menuParent);
        if ($nextParent) {
            $this->adjParentMenu($user, $nextParent, true);
        }

    }

    private function adjParentMenu($user, $parent, $scon = false)
    {
        if ($parent) {
            $userPermList = $user->permissions()->get()->pluck('menu_id', 'menu_id');
            $checkMenu = \App\Models\Menu::active()
                        ->where('parent_id', $parent->menu_id)
                        ->when(count($userPermList) > 0, function($q) use($userPermList) {
                            $q->whereIn('menu_id', $userPermList);
                        })
                        ->get();

            $menuParent = \App\Models\Menu::find($parent->menu_id);
            if (is_null($menuParent)) {
                return;
            }
            $permView = $menuParent->permissions()->where("name", 'like', "%_VIEW")->first();

            if ($hasMenu = $user->permissions()->get()) {
                $hasMenu = $hasMenu->where('permission_id', $permView->permission_id)->isNotEmpty();
            } else {
                $hasMenu = false;
            }

            if (count($checkMenu) > 0) {
                if (!$hasMenu) {
                    $user->assignPermission($permView);
                }
            } else {
                if ($hasMenu) {
                    $user->dismissPermission($permView);

                    // Enter
                    $permEnter = $menuParent->permissions()->where("name", 'like', "%_ENTER")->first();
                    if ($hasMenu = $user->permissions()->get()) {
                        $hasMenu = $hasMenu->where('permission_id', $permEnter->permission_id)->isNotEmpty();
                        if ($hasMenu) {
                            $user->dismissPermission($permEnter);
                        }
                    }
                }
            }

            if ($nextParent = $menuParent->parent) {
                return $nextParent;
            }
        }
        return false;
    }
}
