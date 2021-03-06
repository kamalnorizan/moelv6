<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use Auth;
use Log;
use Carbon\Carbon;
use App\Http\Requests\PostStoreRequest;
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
    public function store(PostStoreRequest $request)
    {

        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();
        if($request->ajax()){
            return response()->json($post);
        }else{
            return redirect()->back();
        }

    }
    public function storejqValidate(Request $request)
    {

        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();
        if($request->ajax()){
            return response()->json($post);
        }else{
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
        Log::error('test');
        Log::alert("alert");
        Log::critical("critical");
        Log::debug("debug");
        Log::emergency("emergency");
        \Sentry\captureMessage('Test 123');
        // try {
        //     $this->functionFailsForSure();
        // }catch(\Throwable $th){
        //     \Sentry\captureException($th);

        // }

        // try {
        //     $post = Post::findOrFail($post);
        //     // dd($post->content);
        // // }catch(ModelNotFoundException $e){
        // //     // echo 'Ada Error post tak wujud';
        // //     // dd($e);
        // //     \Sentry\captureException($e);
        // //     abort(404,$e);
        // }
        // catch (\Throwable $th) {
        //     \Sentry\captureException($th);
        //     abort(404,$th);
        // }

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

    public function testException()
    {
        throw new \Exception('Test sentry');
    }

    public function getLatestPost()
    {
        if(Auth::user()->tokenCan('view-all-posts')){

            $posts = Post::limit(50)->get();
        }else{

            $posts = Post::where('user_id',Auth::user()->id)->limit(20)->latest()->get();
        }
        return response()->json($posts);
    }
}
