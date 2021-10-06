<?php

namespace App\Http\Controllers\PM\Web;


class PM0039Controller extends BaseController
{

    public function index()
    {
        $btnTrans = trans('btn');
        return $this->vue('pm0039',[
            "btn_trans" => $btnTrans,
        ]);
    }


}
