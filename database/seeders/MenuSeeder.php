<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // $data = new \App\Models\Menu;
        // $data->menu_id = 1;
        // $data->menu_code = null;
        // $data->module_code = null;

        // $data->menu_first_level = 'sysadmin';
        // $data->menu_second_level = 'sysadmin';
        // $data->menu_third_level = 'SYSADMIN';

        // $data->permission_code = 'MENU';
        // $data->text_display = 'Menus';
        // $data->url = 'menus';
        // $data->route_name = 'menus.index';
        // $data->server_id = 1;
        // $data->active = true;
        // $data->program_id = -1;
        // $data->last_updated_by = 1;
        // $data->created_by = 1;
        // $data->save();

        \DB::connection('oracle_toat')->table((new \App\Models\Menu)->getTable())->truncate();

        $menus = [
            [
                'menu_id' => -1,
                'menu_title' => 'Menus', 'parent_id' => 0, 'sort_order' => 0, 'url' => '/menus',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                'menu_id' => -2,
                'menu_title' => 'Users', 'parent_id' => 0, 'sort_order' => 0, 'url' => '/users',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'USER'
            ],
            [
                // 'menu_id' => 2,
                'menu_title' => 'Home', 'parent_id' => 0, 'sort_order' => 0, 'url' => '/',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 3,
                'menu_title' => 'Pages', 'parent_id' => 0, 'sort_order' => 1, 'url' => '/pages',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 4,
                'menu_title' => 'Our Services', 'parent_id' => 2, 'sort_order' => 2, 'url' => '/our-services',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 5,
                'menu_title' => 'About', 'parent_id' => 2, 'sort_order' => 3, 'url' => '/about',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 6,
                'menu_title' => 'About Team', 'parent_id' => 4, 'sort_order' => 3, 'url' => '/about-team',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 7,
                'menu_title' => 'About Clients', 'parent_id' => 4, 'sort_order' => 3, 'url' => '/about-clients',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 8,
                'menu_title' => 'Contact Team', 'parent_id' => 5, 'sort_order' => 3, 'url' => '/contact-team',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 9,
                'menu_title' => 'Contact Clients', 'parent_id' => 6, 'sort_order' => 3, 'url' => '/contact-clients',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 10,
                'menu_title' => 'Contact', 'parent_id' => 2, 'sort_order' => 4, 'url' => '/contact',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 11,
                'menu_title' => 'Portfolio', 'parent_id' => 2, 'sort_order' => 4, 'url' => '/portfolio',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ],
            [
                // 'menu_id' => 12,
                'menu_title' => 'Gallery', 'parent_id' => 2, 'sort_order' => 4, 'url' => '/gallery',
                'server_id' => 1, 'program_id' => -1, 'last_updated_by' => -1, 'created_by' => -1,
                'permission_code' => 'MENU'
            ]
        ];
        foreach ($menus as $menu) {
            \App\Models\Menu::Create($menu);
        }
    }
}
