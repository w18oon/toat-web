<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('oracle_toat')->table((new Permission)->getTable())->truncate();

        $data = new Permission;
        $data->permission_id = 1;
        $data->name = 'MENU_ENTER';
        $data->menu_id = -1;
        $data->save();

        $data = new Permission;
        $data->permission_id = 2;
        $data->name = 'MENU_VIEW';
        $data->menu_id = -1;
        $data->save();

        $data = new Permission;
        $data->permission_id = 3;
        $data->name = 'USER_ENTER';
        $data->menu_id = -2;
        $data->save();

        $data = new Permission;
        $data->permission_id = 4;
        $data->name = 'UESR_VIEW';
        $data->menu_id = -2;
        $data->save();
    }
}
