@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div id="errorAlert" class="alert alert-danger @if(!$errors->first()) d-none @endif" role="alert">
                {{-- {{dd($errors->all())}} --}}
                @foreach ($errors->all() as $error)
                {{$error}}<br>
                @endforeach
            </div>

            <div class="card">
                <div class="card-header">Create New Post</div>

                <div class="card-body">

                    <form action="{{route('post.store')}}" method="post" id="postForm">
                        @csrf

                        <div class="form-group">
                          <label for="content">Post</label>
                          <input type="text" class="form-control {{ $errors->first('content') ? 'is-invalid' : '' }}"  name="content" id="content" aria-describedby="helpId" value="{{old('content')}}" placeholder="Insert your post">
                          <small id="helpcontent" class="form-text text-danger">{{$errors->first('content') }}</small>
                        </div>
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"  name="name" id="name" aria-describedby="helpId" value="{{old('name')}}" placeholder="Insert your post">
                          <small id="helpname" class="form-text text-danger">{{$errors->first('name') }}</small>
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"  name="email" id="email" aria-describedby="helpId" value="{{old('email')}}" placeholder="Insert your post">
                          <small id="helpemail" class="form-text text-danger">{{$errors->first('email') }}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" id="submitBtn" class="btn btn-primary">Submit Ajax</button>
                        <button type="button" id="submitBtnJQValidate" class="btn btn-primary">Submit Ajax JQ Validate</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
    $('#submitBtn').click(function (e) {
        e.preventDefault();
        $('.form-text').empty();
        $('.form-control').removeClass('is-invalid');
        $('#errorAlert').empty();
        $('#errorAlert').addClass('d-none');
        $.ajax({
            type: "post",
            url: "{{route('post.store')}}",
            data: {
                _token: '{{ csrf_token() }}',
                content: $('#content').val(),
                name: $('#name').val(),
                email: $('#email').val()
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#postForm')[0].reset();
            },
            error: function(e){
                console.log(e.responseJSON.errors);
                var errors = '';
                $.each(e.responseJSON.errors, function (indexInArray, error) {
                    $('#'+indexInArray).addClass('is-invalid');
                    $('#help'+indexInArray).text(error[0]);
                    errors = errors + error[0] + '<br>';
                });
                $('#errorAlert').removeClass('d-none');
                $('#errorAlert').append(errors);
            }
        });
    });

    $('#submitBtnJQValidate').click(function (e) {
        e.preventDefault();
        if($('#postForm').valid()()){
            alert('ok');
            $.ajax({
                type: "post",
                url: "{{route('post.storejqValidate')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    content: $('#content').val(),
                    name: $('#name').val(),
                    email: $('#email').val()
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('#postForm')[0].reset();
                },
            });
        }
    });
</script>
@endsection
