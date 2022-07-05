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
            if(Auth::user()->id==1){
                $token = Auth::user()->createToken('moeis apps',['view-all-posts'])->accessToken;
            }else{
                $token = Auth::user()->createToken('moeis apps')->accessToken;
            }

            return response()->json( $token);
        }else{
            return response()->json( ['error'=>'Unauthorised'], 401);

        }
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json( ['status'=>'Success']);
    }

    public function getPosts()
    {
        # code...
    }
}
