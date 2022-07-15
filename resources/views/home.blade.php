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
                <div class="card-header">
                    Tokens
                </div>
                <div class="card-body">
                    <table class="table" id="tbl_token">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Scopes</th>
                                <th>Expired At</th>
                                <th>Actions(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Auth::user()->tokens->where('revoked',0) as $token)
                                <tr>
                                    <td>{{$token->name}}</td>
                                    <td>
                                        @foreach ($token->scopes as $scope)
                                        <span class="badge badge-primary">{{$scope}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{\Carbon\Carbon::parse($token->expires_at)->format('d-m-Y')}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger btnRevokeAjax" data-token-id="{{$token->id}}">Revoke Via Ajax</button>

                                        <form action="{{route('user.destroyToken',['token_id'=>$token->id])}}" method="post">
                                            <input type="hidden" name="_method" class="form-control" value="DELETE">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Revoke Via Submit</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    @can('isAdmin')
                        ADA ADMIN <br>
                    @endcan

                    @can('isGuru')
                        ADA GURU  <br>
                    @endcan

                    @can('isBpsh')
                        ADA BPSH  <br>
                    @endcan


                    @foreach ($posts as $post)
                        ~ {{Auth::user()->name}} <br>
                        {{$post->content}}({{$post->id}}-{{$post->id+3}})<hr>

                        @foreach ($post->comments as $comment)
                        ---{{$comment->content}}<br>
                        @endforeach
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    // loadTokens();
    $(document).on('click','.btnRevokeAjax',function(){

        var token_id = $(this).attr('data-token-id');
        $.ajax({
            type: "post",
            url: "oauth/personal-access-tokens/"+token_id,
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE',
            },
            success: function (response) {
                loadTokens();
            }
        });
    });

    function loadTokens(){
        $('#tbl_token tbody').empty();
        $.ajax({
            type: "get",
            url: "{{route('user.getTokens')}}",
            dataType: "json",
            success: function (response) {
                $.each(response, function (indexInArray, token) {
                    var scopeList = '';
                    $.each(token.scopes, function (indexInArray, scope) {
                        scopeList+='<span class="badge badge-primary">'+scope+'</span>';
                    });
                    $('#tbl_token tbody').append(
                        '<tr>'+
                            '<td>'+token.name+'</td>'+
                            '<td>'+
                                scopeList+
                            '</td>'+
                            '<td>'+
                                moment(token.expires_at).format('DD-MM-YYYY')+
                            '</td>'+
                            '<td>'+
                                '<button class="btn btn-sm btn-danger btnRevokeAjax" data-token-id="'+token.id+'">Revoke Via Ajax</button>'+
                            '</td>'+
                        '</tr>'
                    );
                });


            }
        });
    }
</script>
@endsection
