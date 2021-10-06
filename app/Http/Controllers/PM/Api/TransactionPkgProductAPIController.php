<?php

namespace App\Http\Controllers\PM\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionPkgProductAPIController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $command = "declare \n";
        $command .= "v_status varchar2(100); \n";
        $command .= "begin \n";
        $command .= "v_status := apps.ptpm_transaction_pkg.product(p_batch_id => " . $request->input('batch_id') . " \n";
        $command .= ",p_product_date => to_date('" . $request->input('product_date') . "', 'dd/mm/yyyy') \n";
        $command .= ",p_wip_step => " . $request->input('wip_step') ." \n";
        $command .= ",p_machine_set => " . $request->input('machine_set') ."); \n";
        $command .= "dbms_output.put_line(v_status); \n";
        $command .= "end; \n";

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);  
        $ret_code = $stmt->execute();

        return response()->json(['ret_code' => $ret_code],200);
    }
}
