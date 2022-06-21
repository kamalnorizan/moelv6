<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Carbon\Carbon;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user','comments.user')->get(); //eager loading
        // $posts = Post::all(); //lazy loading
        return view('post.index',compact('posts'));
    }

    public function ajaxLoadPostTable(Request $request)
    {


        $posts = Post::with('user');

        if($request->searchPost!=''){
            $posts->where('content','like','%'.$request->searchPost.'%');
        }

        $daterange = explode(' - ',$request->datePost);
        $datestart = Carbon::parse(strtotime($daterange[0]))->format('Y-m-d');
        $dateend = Carbon::parse(strtotime($daterange[1]))->format('Y-m-d');
        $posts->whereBetween('created_at',[$datestart,$dateend]);

        return Datatables::of($posts)
        ->addIndexColumn()
        ->addColumn('author',function (Post $post){
            $author = $post->user->name;
            return $author;
        })
        ->addColumn('comments',function (Post $post){
            $options = '';
            foreach ($post->comments as $key => $comment) {
                $options .= '<option value="'.$comment->id.'">'.$comment->content.'</option>';
            }
            $dropdown = '<select name="test" id="test" class="form-control ddcomment">'.$options.'</select>';

            return $dropdown;
        })
        ->addColumn('actions',function (Post $post){
            $button = '<button data-toggle="modal" data-target="#mdl-edit" type="button" class="btn btn-sm btn-warning btnEdit" data-content="'.$post->content.'" data-id="'.$post->id.'">Edit</button>';

            $button .='<button type="button" class="btn btn-sm btn-danger btnDelete"  data-id="'.$post->id.'">Delete</button>';

            return $button;
        })
        ->rawColumns(['author','comments','actions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'content'=>'required|max:255',
            'name'=>'required|alpha_num',
            'email'=>'email',
        ]);

        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()->back();

        // $inputs = $request->all();
        // $inputs['user_id']=Auth::user()->id;
        // Post::create($inputs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->id!=''){
            $post = Post::find($request->id);
            $post->update($request->all());
        }else{
            $post = new Post;
            $post->content = $request->content;
            $post->user_id = Auth::user()->id;
            $post->save();
        }
        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Post::find($request->id)->delete();
        return response()->json(['status'=>'success']);
    }
}
