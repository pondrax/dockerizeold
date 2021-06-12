<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Jobs\ExampleJob;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function __construct(){
        //$this->middleware('auth');
    }

    public function read(){
		dispatch(new ExampleJob);
		//echo 'job';

    }

}
