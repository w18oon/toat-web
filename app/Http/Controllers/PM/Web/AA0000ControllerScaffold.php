<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0006ApiController;
use Illuminate\Http\Request;

class AA0000ControllerScaffold extends BaseController
{
    /**
     * @var PM0006ApiController
     */
    private $api;

    /**
     * PM0033Controller constructor.
     * @param PM0006ApiController $api
     */
    public function __construct(PM0006ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
    }
}
