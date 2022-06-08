@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Posts</div>
                <div class="card-body">


                    <table class="table" id="postsTbl">
                        <thead>
                            <tr>
                                <th>Post</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>

        $('#postsTbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "method":'post',
              "url": "{{ route('post.ajaxLoadPostTable') }}",
              "dataType": "json",
              "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
              { "data": "content" },
              { "data": "author" },
              { "data": "comments" },
              { "data": "updated_at" }
            ]
        });

        $(document).on('change','.ddcomment', function(){
            alert($(this).val());
        });

        $('.ddcomment').change(function (e) {
            e.preventDefault();

        });
    </script>


@endsection
