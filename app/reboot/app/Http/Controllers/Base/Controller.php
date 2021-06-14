<?php

namespace App\Http\Controllers\Base;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	private function authHeader(){
        try {
            $user = auth()->userOrFail();
            $header['jwt'] = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }
        return $header;
	}

    public function response($message, $data = null, $code = 200, $header = [])
    {
        try {
            $user = auth()->userOrFail();
            $header['jwt'] = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }
        if(!is_string($message)){
			$data		= $message;
			$message	= 'default';
		}
		$props = $data;

        if($data instanceof LengthAwarePaginator){
			$props	= $data->first();
			$data	= $data->toArray();
			$meta	= ['links','path','first_page_url','prev_page_url','next_page_url','last_page_url'];
			$data 	= array_diff_key($data, array_flip($meta));
		}
		try{
			if(!is_array($props)){
				$props = $props==null || is_int($props) ? []: flatten($props->toArray());
			}
			$data['message'] = __("message.$message", $props);
		}catch(\Exception $e){}

        return response()->json($data, $code, $header);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
