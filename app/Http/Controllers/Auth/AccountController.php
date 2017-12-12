<?php

namespace App\Http\Controllers\Auth;

use App\Transformers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function changeData(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'password' => 'required|min:6'
        ]);
        $user = $request->user()->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);
        return response()->json(Json::response(null, 'success'));
    }
}
