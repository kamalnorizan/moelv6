@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search User</div>

                <div class="card-body">
                    <form action="{{route('searchUser')}}" method="post">
                        @csrf
                        <div class="form-group">
                          <label for="user_id">Search</label>
                          <input type="text" class="form-control" name="user_id" id="user_id" aria-describedby="helpId" placeholder="">
                          <small id="helpId" class="form-text text-muted">Help text</small>
                        </div>
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div> --}}
        <div class="col-md-8 mt-3">
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
