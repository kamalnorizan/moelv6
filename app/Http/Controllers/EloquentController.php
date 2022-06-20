<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class EloquentController extends Controller
{
    public function index()
    {
        // $users = User::has('posts')->get();
        // $users = User::has('posts')->has('comments')->get();
        // $users = User::has('posts')->orhas('comments')->get();
        // $users = User::has('posts.comments')->get();
        // $users = User::with('posts')->has('posts','>',3)->get();


        $users = User::with(['posts'=>function($q){
            $q->select('content');
        }])
        ->has('posts')
        // ->wherehas('posts',function($q){
        //     $q->where('content','like','%rem%');
        // })
        // ->wherehas('posts.comments',function($q){
        //     $q->where('content','like','%rem%');
        // })
        ->get();

        dd($users->first());

        // $userCheck = User::where('name','Tremaine Skiles')->first();
        // $users = $users->load('posts.comments');
        // $type='pelajar';
        // $users = User::select('name')
        // ->where(function($q){
        //     $q->where('email','like','%gmail%')
        //     ->orWhere('email','like','%example.com%');
        // })
        // ->whereDate('created_at','<','2022-06-10');
        // // ->get();

        // $users->when($type=='pelajar',function($q) use ($type){
        //     $q->whereDate('created_at','>','2022-06-08');
        // });

        // if($type=='pelajar'){
        //     $users->whereDate('created_at','>','2022-06-08');
        // }

        // $users = $users->get();

        foreach ($users as $key => $user) {
            // echo $user->id.'. '.$user->name.'('.$user->posts->count().')<br>';
            // echo $user->id.'. '.$user->name.'<br>';
            // foreach ($user->posts as $key => $post) {
            //     echo '-'.$post->content.'<br>';
            // }
            echo $user->id.'. '.$user->name.' - '.$user->email.'-'.$user->created_at;
            echo '<hr>';
        }

        // $user = User::find(2);
        // dd($user->posts);
    }
}
