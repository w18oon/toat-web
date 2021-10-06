<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('oracle_toat')->table((new \App\Models\User)->getTable())->truncate();

        $user = new \App\Models\User;
        $user->name = 'SYSADMIN';
        $user->username = 'sysadmin';
        $user->email = 'mcr@test.com';
        $user->email_verified_at = now();
        $user->password = bcrypt('welcome');
        $user->remember_token = \Str::random(10);
        $user->last_updated_by = -1;
        $user->created_by = -1;
        $user->save();

        $permissions = \App\Models\Permission::whereIn('permission_id', [1, 2, 3, 4])->get();
        foreach ($permissions as $key => $permission) {
            $user->assignPermission($permission);
        }
    }
}
