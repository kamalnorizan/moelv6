@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Custom Filter</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="searchPost" id="searchPost" class="form-control" placeholder="Sila masukkan carian untuk Post">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="datePost" id="datePost" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">Posts <button id="addPostBtn" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#mdl-edit" >Create Post</button></div>
                <div class="card-body">
                    <table class="table" id="postsTbl">
                        <thead>
                            <tr>
                                <th>Post</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Created At</th>
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

                <input type="hidden" name="post-id" id="post-id" class="form-control" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" data-dismiss="modal" id="updateBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $('#datePost').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        var postTable = $('#postsTbl').DataTable({
            "order":[[3,'desc']],
            "processing": true,
            "serverSide": true,
            "ajax":{
             "method":'post',
              "url": "{{ route('post.ajaxLoadPostTable') }}",
              "dataType": "json",
              "data": function(d){
                   d._token="{{csrf_token()}}";
                   d.datePost=$('#datePost').val();
                   d.searchPost=$('#searchPost').val();
                }
            },
            "columns": [
              { "data": "content" },
              { "data": "author", "name": "user.name"},
              { "data": "comments" },
              { "data": "created_at" },
              { "data": "actions" }
            ]
        });

        $(document).on('change','.ddcomment', function(event){
            console.log(event);
        });

        $(document).on('click','.btnDelete',function(e){
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this post  again!",
                icon: "warning",
                buttons: {cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes, i'm sure!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }}
            }).then((value)=>{
                if(value==true){
                    $.ajax({
                        type: "post",
                        url: "{{route('post.delete')}}",
                        data: {
                            _token: '{{csrf_token()}}',
                            id: id
                        },
                        dataType: "json",
                        success: function (response) {
                            swal("Deleted!", "The post has been deleted successfully.", "success");
                            postTable.ajax.reload(null, false);
                        }
                    });
                }
            });
        });

        $('#mdl-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var content = button.data('content');
            $('#content').val(content);
            $('#post-id').val(id);
        });


        $('#updateBtn').click(function (e) {
            $.ajax({
                type: "post",
                url: "{{route('post.update')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $('#post-id').val(),
                    content: $('#content').val()
                },
                dataType: "json",
                success: function (response) {
                    postTable.ajax.reload(null, false);
                }
            });
        });

    </script>


@endsection
