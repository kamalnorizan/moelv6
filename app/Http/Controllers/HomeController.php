<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Auth;
use App\Post;
use DB;
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

        $posts = DB::table('posts')->first();
        $postsLast = DB::table('posts')->orderBy('id','desc')->first();
        // dd($posts);
        // dd($postsLast);

        // $posts = DB::table('posts')->get();
        // dd($posts->first());
        // dd($posts->last());


        $posts = Post::where('user_id',Auth::user()->id)->get();
        // dd($posts);

        // dd($posts->where('id',88));

        return view('home',compact('posts'));
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
