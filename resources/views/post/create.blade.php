@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                {{-- {{dd($errors->all())}} --}}
                @foreach ($errors->all() as $error)
                {{$error}}<br>
                @endforeach
            </div>
            <div class="card">
                <div class="card-header">Create New Post</div>

                <div class="card-body">

                    <form action="{{route('post.store')}}" method="post" >
                        @csrf

                        <div class="form-group">
                          <label for="content">Post</label>
                          <input type="text" class="form-control {{ $errors->first('content') ? 'is-invalid' : '' }}"  name="content" id="content" aria-describedby="helpId" value="{{old('content')}}" placeholder="Insert your post">
                          <small id="helpId" class="form-text text-danger">{{$errors->first('content') }}</small>
                        </div>
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"  name="name" id="name" aria-describedby="helpId" value="{{old('name')}}" placeholder="Insert your post">
                          <small id="helpId" class="form-text text-danger">{{$errors->first('name') }}</small>
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"  name="email" id="email" aria-describedby="helpId" value="{{old('email')}}" placeholder="Insert your post">
                          <small id="helpId" class="form-text text-danger">{{$errors->first('email') }}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
