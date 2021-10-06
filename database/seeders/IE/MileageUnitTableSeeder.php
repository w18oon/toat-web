<?php
namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;

class MileageUnitTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oaie')->table('ptw_mileage_units')->truncate();
        DB::connection('oracle_oaie')->table('ptw_mileage_units')->insert($this->mileage_units());
    }

    public function mileage_units()
    {
        $lists = [
            [
                'code' => 'KM', 'description' => 'Kilometre(s)' ,'active' => true,
                'last_updated_by' => -1, 'created_by' => -1,
                'creation_date' => date('Y-m-d H:i:s'), 'last_update_date' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'MILE', 'description' => 'Mile(s)' ,'active' => true,
                'last_updated_by' => -1, 'created_by' => -1,
                'creation_date' => date('Y-m-d H:i:s'), 'last_update_date' => date('Y-m-d H:i:s'),
            ],
        ];

        return $lists;
    }
}