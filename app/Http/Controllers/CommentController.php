<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;
use App\Jobs\SendEmailAttachment;
use Mail;
use PDF;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::limit(30)->get();
        dispatch(new SendEmailJob($comments));

        // $comments = Comment::limit(30)->get();
        // $pdf = PDF::loadView('comment.commentlist',compact('comments'));
        // dispatch(new SendEmailAttachment($pdf->output()));


        // Mail::to('kamalnorizan@gmail.com')->send(new MailComment);
        // Mail::send('comment.mail', ['status'=>'success'], function ($message) {
        //     $message->to('kamalnorizan@gmail.com', 'Kamal Norizan');
        //     $message->subject('Test Email');
        // });
        return view('comment.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
