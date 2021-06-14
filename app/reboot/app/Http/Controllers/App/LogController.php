<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\Logs;
use Illuminate\Http\Request;
use Jackiedo\LogReader\Facades\LogReader;

class LogController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function read(Request $request, $id = 'all')
    {
        if ($id == 'system') {
            define('GLOB_BRACE', 0x10);
            $sort = $request->input('sort', 'date');
            $order = $request->input('order', 'desc');
            $limit = $request->input('limit', 15);
            $result = LogReader::orderBy($sort, $order)->paginate($limit);
            $result = $result->toArray();
            $data = [];
            foreach ($result['data'] as $item) {
                $data[] = $item;
            }
            $result['data'] = $data;
        } else {
            $result = Logs::table();
        }

        return $this->response($result);
    }
}
