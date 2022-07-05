<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class UserController extends Controller
{
    public function ssoLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
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

    // public function userTokens()
    // {
    //     $users = User::first();
    // }
}
