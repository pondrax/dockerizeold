<?php

namespace App\Http\Controllers\Base;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function auth()
    {
        return Auth();
    }

    public function response($data, $code = 200, $header = [])
    {
        try {
            $user = Auth::userOrFail();
            $header['jwt'] = Auth::refresh();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }

        return response()->json($data, $code, $header);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
