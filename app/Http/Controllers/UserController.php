<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Passport\Token as ClientToken;
use Auth;
class UserController extends Controller
{
    public function ssoLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // dd($request->roles);
        if($user){
            $request->session()->put('email',$request->email);
            if($request->roles!=null){
                $roles = explode('|',$request->roles);
                $request->session()->put('roles',$roles);
            }

            // dd($request->session()->get('roles'));
            Auth::loginUsingId($user->id);

            return redirect('home');
        }else{
            return redirect('login');
        }
    }

    public function getTokens()
    {
        $tokens = Auth::user()->tokens->where('revoked',0);
        return response()->json($tokens);
    }

    public function destroyToken($token_id)
    {
        $token = ClientToken::find($token_id)->revoke();
        return redirect()->back();
    }
}
