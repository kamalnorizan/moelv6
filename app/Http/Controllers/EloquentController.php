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
        // $users = User::with('posts')->get();

        $users = User::with(['posts'=>function($q){
            $q->where('content','like','%rem%');
        },'posts.comments'=>function($q){
            $q->where('content','like','%rem%');
        }])
        ->wherehas('posts',function($q){
            $q->where('content','like','%rem%');
        })
        ->wherehas('posts.comments',function($q){
            $q->where('content','like','%rem%');
        })
        ->get();

        foreach ($users as $key => $user) {
            // echo $user->id.'. '.$user->name.'('.$user->posts->count().')<br>';
            echo $user->id.'. '.$user->name.'<br>';
            foreach ($user->posts as $key => $post) {
                echo '-'.$post->content.'<br>';
            }
            echo '<hr>';
        }

        // $user = User::find(2);
        // dd($user->posts);
    }
}
