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
						->with('route:menu_id,method,route,data')
						->orderBy('num', 'asc')
						->table(),
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
        $data	= Route::validate(request()->all(), 'generate');
        $result	= Route::insert($data);

        return $this->response($data);
    }

    public function create()
    {
        $data	= Route::validate(request()->all(), 'save');
        $result	= Route::create($data);

        return $this->response('created', $result, 201);
    }

    public function update($id)
    {
        $data	= Route::validate(request()->all(), 'save', $id);
        $result	= Route::find($id);
        $result->update($data);

        return $this->response('updated', $result);
    }

    public function delete($id)
    {
		$ids	= explode(',', $id);
		$result	= Route::whereIn('id', $ids)->whereDeletable(true)->delete();

        return $this->response('deleted', ['id' => $id]);
    }
}
