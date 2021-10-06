<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function vue($vueComponent, $params = [])
    {
        return view('pd.Vue', ['vueComponent' => $vueComponent] + $params);
    }
}
