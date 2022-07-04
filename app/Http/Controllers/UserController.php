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
            Auth::loginUsingId($user->id);
            return redirect('home');
        }else{
            return redirect('login');
        }
    }
}
