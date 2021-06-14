<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\Logaudit;

class LogauditController extends Controller
{
    public function read($read = 'all')
    {
        $result = Logaudit::table();

        return $this->response($result);
    }

}
