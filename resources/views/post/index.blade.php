@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Posts</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Post</td>
                            <td>Author</td>
                            <td>Comments</td>
                            <td>Action(s)</td>
                        </tr>
                        @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->content}}</td>
                            <td>{{$post->user->name}}</td>
                            <td>
                                @foreach ($post->comments as $comment)
                                    {{$comment->user->name}}<br>
                                @endforeach
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
