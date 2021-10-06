<?php

namespace App\Http\Controllers\PM\Web;

class ExampleDbLookupController extends BaseController
{
    public function index()
    {
        return $this->vue('mock-db-lookup-example');
    }
}
