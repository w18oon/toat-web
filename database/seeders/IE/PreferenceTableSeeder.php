<?php
namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;

class PreferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oaie')->table('ptw_preferences')->truncate();
        DB::connection('oracle_oaie')->table('ptw_preferences')->insert($this->preferences());
    }

    public function preferences()
    {
        $lists = [
            [
                'code' => 'pending_day_blocking', 'data_type'=> 'varchar', 'data_value' => '["0"]',
                'last_updated_by' => -1, 'created_by' => -1,
                'creation_date' => date('Y-m-d H:i:s'), 'last_update_date' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'unblock_users', 'data_type'=> 'json', 'data_value' => null,
                'last_updated_by' => -1, 'created_by' => -1,
                'creation_date' => date('Y-m-d H:i:s'), 'last_update_date' => date('Y-m-d H:i:s'),
            ],
        ];

        return $lists;
    }
}
