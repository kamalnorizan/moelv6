<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class ApiController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($data)){
            $token = Auth::user()->createToken('moeis apps')->accessToken;

            return response()->json( $token);
        }else{
            return response()->json( ['error'=>'Unauthorised'], 401);

        }
    }
}
