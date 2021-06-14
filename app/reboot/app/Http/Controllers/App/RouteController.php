<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\Route;
use App\Models\Menu;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function collection($read = 'all'){
        $result = [
			'app' => Menu::select('id','menu','icon')
				->has('route')
				->with('route:menu_id,method,route,description')
				->orderBy('num','asc')
				->get()
		];
        return $this->response($result);
    }

    public function read($read = 'all'){
        $result = Route::with('menu')->table();
        return $this->response($result);
    }

    public function generate(Request $request){
		$data	= Route::validate($request, 'save');
		$result	= Route::insert($data);
        return $this->response($data);
    }

    public function create(Request $request){
		$data	= Route::validate($request, 'save');
		$result	= Route::insert($data);
        return $this->response($data);
    }

    public function update(Request $request, $id){
		$data 	= Route::validate($request, 'save', $id);
        $result = Route::where('id',$id)->update($data);
		return $this->response(['message'=>"Updated ($id)"]);
    }

    public function delete($id){
		$ids = explode(',',$id);
		$result = Route::find($ids)->each(function($data, $key){
			$data->delete();
		});
		return $this->response(['message'=>"Deleted ($id)"]);
    }

}
