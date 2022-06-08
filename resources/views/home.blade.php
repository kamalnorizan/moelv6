@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @foreach (Auth::user()->posts as $post)
                        ~ {{$post->user->name}} <br>
                        {{$post->content}}<hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
