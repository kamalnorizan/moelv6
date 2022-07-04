<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class UserController extends Controller
{
    public function ssoLogin(Request $request)
    {
        $request->session()->put('email',$request->email);
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        dd($user);
    }
}
