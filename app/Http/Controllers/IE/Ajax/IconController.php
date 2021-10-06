<?php

namespace App\Http\Controllers\IE\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function index(Request $request)
    {
        $iconClass = $request->icon;
        if(!$iconClass){ return ; }
        return view('layouts._icon',compact('iconClass'));
    }
}
