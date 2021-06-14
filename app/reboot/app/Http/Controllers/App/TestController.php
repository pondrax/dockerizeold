<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Jobs\ExampleJob;

class TestController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function read()
    {
        dispatch(new ExampleJob());
        //echo 'job';
    }
}
