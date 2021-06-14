<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
//use App\Models\User;
//use App\Notifications\Notify;

use Illuminate\Http\Request;
use Jackiedo\LogReader\Facades\LogReader;

class LogsystemController extends Controller
{
    public function read(Request $request, $read = 'all')
    {
        define('GLOB_BRACE', 0x10);
        $sort = $request->input('sort', 'date');
        $order = $request->input('order', 'desc');
        $limit = $request->input('limit', 15);

        $result = LogReader::orderBy($sort, str_replace('ending', '', $order))->paginate($limit);
        $result = $result->toArray();
        $data = [];
        foreach ($result['data'] as $item) {
            $data[] = $item;
        }
        $result['data'] = $data;
        //return response()->json('test');
        return $this->response($result);
    }

    public function delete($id)
    {
        if ($id == 'all') {
            LogReader::delete();
        } else {
            $ids = explode(',', $id);
            foreach ($ids as $id) {
                LogReader::find($id)->delete();
            }
        }

        return $this->response(['message'=>'Berhasil dihapus']);
    }

    //public function testo(){
        //$cache = \Cache::getRedis()->keys("*");
        //return $this->response($cache);
    //}
    //public function test(){
        //$data= ['message'=>'coba'];
        //$user = User::find(1);
        //$user->notify(new Notify($data));
        //return response()->json($user);
    //}
}
