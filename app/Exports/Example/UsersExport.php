<?php

namespace App\Exports\Example;

use App\Models\Example\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
   public function view(): View
    {
        $users = User::limit(20)->get();

        return view('example.users.exports.excel', [
            'users' => $users,
        ]);
    }
}
