<?php

namespace App\Http\Controllers\PM\Web;


class PM0038Controller extends BaseController
{
    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0038',[
            "btn_trans" => $btnTrans,
        ]);
    }
}
