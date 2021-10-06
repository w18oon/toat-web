<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // IExpense
        // $this->call(IE\LocationTableSeeder::class);
        // $this->call(IE\CategoryTableSeeder::class);
        // $this->call(IE\SubCategoryTableSeeder::class);
        // $this->call(IE\PreferenceTableSeeder::class);
        // $this->call(IE\MileageUnitTableSeeder::class);


        $this->call(ServersTableSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserSeeder::class);
    }
}
