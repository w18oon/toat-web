<?php

namespace App\Http\Controllers\Example;

use App\Models\Example\User;
use App\Http\Requests\Example\StoreUserRequest;
use App\Exports\Example\UsersExport;
use App\Models\Example\UserInterface;

use App\Http\Controllers\Controller;
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

        return view('example.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        return view('example.users.create', compact('user'));
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
        $data['password'] = bcrypt($request->password ?? '123456');
        $data['last_updated_by'] = $userId;
        $data['created_by'] = $userId;

        User::create($data);

        return redirect()->route('example.users.index')->with('success','ทำการเพิ่มสมาชิกในระบบเรียบร้อยแล้ว');
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
        return view('example.users.edit', compact('user'));
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
            $user->email = $request->email;
            $user->last_updated_by = $userId;
            $user->last_update_date = now();
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            \DB::commit();
            return redirect()->route('example.users.index')->with('success', 'ทำการอัพเดตสมาชิกในระบบเรียบร้อยแล้ว');
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
            return redirect()->route('example.users.index')->with('success', 'ทำการลบสมาชิกในระบบเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
        //
    }

    public function exportExcel()
    {
        return \Excel::download(new UsersExport, 'users.xlsx');
    }

    public function exportPdf()
    {
        $users = User::limit(20)->get();
        $pdf = \PDF::loadView('example.users.exports.pdf', ['users' => $users])
            ->setPaper('a4')
            ->setOption('margin-top', '0.5cm')
            ->setOption('margin-bottom', '5cm')
            ->setOption('margin-left', '0.7cm')
            ->setOption('margin-right', '0.7cm');

        return $pdf->inline();
    }

    public function interface()
    {
        $result = (new UserInterface)->success();
        if($result["status"] == "E") {
            return redirect()->route('example.users.index')->withErrors('ทำการอินเตอร์เฟสเข้าระบบไม่สำเร็จ');
        }
        if($result["status"] == "S") {
            return redirect()->route('example.users.index')->with('success', 'ทำการอินเตอร์เฟสเข้าระบบเรียบร้อยแล้ว');
           throw new \Exception('ทำรับไม่สำเร็จ');
        }

        return $pdf->inline();
    }

    public function interfaceError()
    {
        $result = (new UserInterface)->error();
        if($result["status"] == "E") {
            return redirect()->route('example.users.index')->withErrors('ทำการอินเตอร์เฟสเข้าระบบไม่สำเร็จ');
        }
        if($result["status"] == "S") {
            return redirect()->route('example.users.index')->with('success', 'ทำการอินเตอร์เฟสเข้าระบบเรียบร้อยแล้ว');
           throw new \Exception('ทำรับไม่สำเร็จ');
        }

        return $pdf->inline();
    }
}
