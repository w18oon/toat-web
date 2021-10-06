<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Server;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('oracle_toat')->table((new Server)->getTable())->truncate();

        $data = new Server;
        $data->server_id = 1;
        $data->ip = '192.168.10.40';
        $data->hostname = '-';
        $data->description = 'คลองเตย';
        $data->last_updated_by = -1;
        $data->created_by = -1;
        $data->save();

        $data = new Server;
        $data->server_id = 2;
        $data->ip = '192.168.10.40';
        $data->hostname = '-';
        $data->description = 'โรจนะ';
        $data->last_updated_by = -1;
        $data->created_by = -1;
        $data->save();
    }
}
