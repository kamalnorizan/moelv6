<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if(Gate::denies('isAdmin')){
        //     return redirect('home');
        // }

        // dd(Auth::user());
        \Artisan::call('optimize:clear');

        if(Gate::allows('isBpsh')){

        }elseif(Gate::allows('isGuru')){

        }


        return view('home');
    }

    public function untukAdmin()
    {
        dd('admin');
    }

    public function untukGuru()
    {
        dd('Guru');
    }

    public function untukBpsh()
    {
        dd('Bpsh');
    }
}
