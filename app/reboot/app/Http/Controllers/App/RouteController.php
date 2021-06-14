<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use App\Models\Menu;
use App\Models\Route;

class RouteController extends Controller
{
    public function collection($read = 'all')
    {
        $result = [
            'data' => [
				'app' => Menu::select('id', 'menu', 'icon')
					->has('route')
					->with('route:menu_id,method,route,description')
					->orderBy('num', 'asc')
					->get(),
			]
        ];

        return $this->response($result);
    }

    public function read($read = 'all')
    {
        $result = Route::with('menu')->table();

        return $this->response($result);
    }

    public function generate()
    {
        $data	= Route::validate(request(), 'save');
        $result	= Route::insert($data);

        return $this->response($data);
    }

    public function create()
    {
        $data	= Route::validate(request(), 'save');
        $result	= Route::create($data);
		//var_dump($result);
        return $this->response('created', $result);
    }

    public function update($id)
    {
        $data	= Route::validate(request(), 'save', $id);
        $result	= Route::find($id);
        $result->update($data);

        return $this->response('updated', $result);
    }

    public function delete($id)
    {
		$ids	= explode(',', $id);
		$result	= Route::whereIn('id', $ids)->delete();

        return $this->response('deleted', $result);
    }
}
