<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oaie')->table('ptw_locations')->truncate();
        DB::connection('oracle_oaie')->table('ptw_locations')->insert($this->locations());


        $locations = DB::connection('oracle_oaie')->table('ptw_locations')->get();
        foreach ($locations as $key => $location) {
            DB::connection('oracle_oaie')->table('ptw_accessible_orgs')->insert(
                [
                    'accessible_orgable_id' => $location->location_id,
                    'accessible_orgable_type' => 'App\Models\IE\Location',
                    'org_id' => '81',
                    'creation_date' => date('Y-m-d H:i:s'),
                    'last_update_date' => date('Y-m-d H:i:s'),
                    'last_updated_by' => -1,
                    'created_by' => -1
                ]
            );
        }
    }

    public function locations()
    {
        $lists = [];

        array_push($lists,
            [
            'name' => 'Domestic',
            'description' => 'Domestic (ภายในประเทศ)' ,
            'active' => true,
            'creation_date' => date('Y-m-d H:i:s'),
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_updated_by' => -1,
            'created_by' => -1
        ]);

        array_push($lists,
            [
            'name' => 'Japan',
            'description' => 'Japan (ประเทศญี่ปุ่น)' ,
            'active' => true,
            'creation_date' => date('Y-m-d H:i:s'),
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_updated_by' => -1,
            'created_by' => -1
        ]);

        array_push($lists,
            [
            'name' => 'Zone A',
            'description' => 'Brunei, Cambodia, Indonesia, Laos, Malaysia, Myanmar, Philippines and Vietnam (บรูไน, กัมพูชา, อินโดนีเซีย, ลาว, มาเลเซีย, พม่า, ฟิลิปปินส์ และเวียดนาม)' ,
            'active' => true,
            'creation_date' => date('Y-m-d H:i:s'),
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_updated_by' => -1,
            'created_by' => -1
        ]);

        array_push($lists,
            [
            'name' => 'Zone B',
            'description' => 'Australia, Bahrain, China, Fiji, India, Israel, North / South Korea, Lebanon, Macau, Maldives, Mauritius, Mongolia, Nepal, New Zealand, Oman, Pakistan, Qatar (ออสเตรเลีย, บาห์เรน, จีน, ฟิจิ, อินเดีย, อิสราเอล, เกาหลีเหนือ/ใต้, เลบานอน, มาเก๊า, มัลดีฟส์, มอริเชียส, มองโกเลีย, เนปาล, นิวซีเลนด์, โอมาน, ปากีสถาน, การ์ต้า)',
            'active' => true,
            'creation_date' => date('Y-m-d H:i:s'),
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_updated_by' => -1,
            'created_by' => -1
        ]);

        array_push($lists,
            [
            'name' => 'Zone C',
            'description' => 'Other Country not in Zone A,B (ประเทศอื่นๆ ที่ไม่อยู่ในโซน A,B)' ,
            'active' => true,
            'creation_date' => date('Y-m-d H:i:s'),
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_updated_by' => -1,
            'created_by' => -1
        ]);

        return $lists;
    }

}