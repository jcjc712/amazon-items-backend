<?php

namespace App\Http\Controllers\Auth;

use App\Transformers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logoutAllDevices(Request $request)
    {
        if(count($request->user()->authAcessToken) > 0){
            $request->user()->authAcessToken()->delete();
        }
        return response()->json(Json::response(null, 'success'));
    }

    public function logoutDevice(Request $request)
    {
        $request->user()->token()->delete();
        return response()->json(Json::response(null, 'success'));
    }
}