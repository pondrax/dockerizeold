<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use Illuminate\Http\Request;

class ManagecacheController extends Controller
{

    public function read(Request $request, $id = 'all'){
		$cache = \Cache::getRedis()->keys("*");
		return $this->response($cache);
    }

	public function delete($id){
		//if($id == 'all'){
			//LogReader::delete();
		//}else{
			//$ids = explode(',', $id);
			//foreach($ids as $id){
				//LogReader::find($id)->delete();
			//}
		//}
		return $this->response(['message'=>'Berhasil dihapus']);
	}
}
