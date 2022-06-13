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
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mdl-edit">
  Launch
</button>

<!-- Modal -->
<div class="modal fade" id="mdl-edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="content">Post</label>
                  <textarea class="form-control" name="content" id="content" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
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
              { "data": "actions" }
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
