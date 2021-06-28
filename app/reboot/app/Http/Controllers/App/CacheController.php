<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;

class CacheController extends Controller
{

    public function read($read = 'all')
    {
		$prefix	= config('database.redis.options.prefix') . cache()->getPrefix();
        $keys	= cache()->getRedis()->keys("*");
        $data	= [];
		foreach($keys as $key){
			$key	= str_replace($prefix, '', $key);
			$data[]	= [
				'id'	=> $key,
				'value' => cache($key)
			];
		}
        $result	= [
			'data'	=> $data,
			'total'	=> count($keys)
		];

        return $this->response($result);
    }

    public function create()
    {
		$data	= $this->validate(request(), ['id'=>'required', 'value'=>'required']);
		cache([$data['id'] => $data['value']]);
		$result	= $data;

		return $this->response('created', $result, 201);
    }

    public function delete($id)
    {
		$ids	= explode(',', $id);
		foreach($ids as $key){
			cache()->forget($key);
		}
		$result	= ['id' => $ids];

        return $this->response('deleted', $result);
    }
}
