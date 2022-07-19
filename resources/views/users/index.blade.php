@extends('layouts.app')
@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Roles <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addRole-mdl">
                    Add Role
                  </button></div>

                <div class="card-body">
                   <table class="table" id="role_tble">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            Permissions
                        </td>
                        <td>
                            Action(s)
                        </td>
                    </tr>
                    @foreach ($roles as $role)
                    <tr>
                        <td>
                            {{$role->name}}
                        </td>
                        <td class="permission-div">
                            {{-- <div class="permission-div"> --}}
                                @foreach ($role->permissions as $permission)
                                    <span class="badge badge-primary">{{$permission->name}}</span>
                                @endforeach
                            {{-- </div> --}}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a type="button" class="dropdown-item assignPermissionBtn" data-toggle="modal" data-target="#assignPermission-mdl" data-roleid="{{$role->id}}" data-permissions="{{$role->permissions}}">Assign Permission</a>
                                  <a href="{{route('user.role.remove',['role'=>$role->id])}}" class="dropdown-item">Remove</a>
                                </div>
                              </div>
                        </td>
                    </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
        {{-- @role('Cikgu') --}}
        @can('Posts Module')
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Permissions
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#createPermission-mdl">
                        Add Permission
                    </button>
                </div>

                <div class="card-body">
                   <table class="table">
                    <tr>
                        <td>Permission</td>
                        <td>Action(s)</td>
                    </tr>
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$permission->name}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
        @endcan
        {{-- @endrole --}}
        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                   {{-- table.table>(thead>tr>th*5)+tbody --}}
                   <table class="table" id="usertbl">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role(s)</th>
                            <th>Permission(s)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addRole-mdl" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{route('user.role.store')}}" method="post">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="roleName">Role</label>
                    <input type="text" name="roleName" id="roleName" class="form-control" placeholder="Insert role name" aria-describedby="helpId">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createPermission-mdl" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{route('user.permission.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                    <label for="permissionName">Permission Name</label>
                    <input type="text" name="permissionName" id="permissionName" class="form-control" placeholder="Enter permission name" aria-describedby="helpId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="assignPermission-mdl" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="roleId_permission" id="roleId_permission" class="form-control" value="">

                <div class="row">
                    @foreach ($permissions as $permission)
                    <div class="col-md-4">
                        <input type="checkbox" name="ck_permission" id="ck_permission_{{$permission->id}}" class="ck_permission" data-permissionid="{{$permission->id}}">{{$permission->name}}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    var clickedAssignBtn;
    $(document).on('click','.assignPermissionBtn',function(){
        var button = $(this);
        clickedAssignBtn = button;
        var role_id = button.attr('data-roleid');
        var permissions = jQuery.parseJSON(button.attr('data-permissions'));
        $('#roleId_permission').val(role_id);
        $.each($('.ck_permission'), function (indexInArray, ck_permission) {
            $(ck_permission).prop('checked',false);
        });

        $.each(permissions, function (indexInArray, permission) {
            $('#ck_permission_'+permission.id).prop('checked',true);
        });
    });

    $('.ck_permission').change(function (e) {
        var permissionId = $(this).attr('data-permissionid');
        $.ajax({
            type: "post",
            url: "{{route('user.role.assignpermission')}}",
            data: {
                _token: '{{ csrf_token() }}',
                role: $('#roleId_permission').val(),
                permission: permissionId,
                assign: $(this).prop('checked')
            },
            dataType: "json",
            success: function (response) {
                console.log($(clickedAssignBtn).attr('data-permissions'));

                $(clickedAssignBtn).attr('data-permissions',JSON.stringify(response.permissions));

                var permissionDiv = $(clickedAssignBtn).parents().closest('tr').children('td.permission-div');

                $(permissionDiv).empty();
                $.each(response.permissions, function (indexInArray, permission) {
                    $(permissionDiv).append(
                        '<span class="badge badge-primary">'+permission.name+'</span> '
                    );
                });
            }
        });
    });

    var usertbl = $('#usertbl').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "method": 'post',
            "url": "{{ route('user.ajaxloadusers') }}",
            "dataType": "json",
            "data":{ _token: "{{csrf_token()}}"}
        },
        "columns": [
            { "data": "name" },
            { "data": "email" },
            { "data": "role" },
            { "data": "permission" },
            { "data": "action" }
        ]
    });

    $(document).on('click','.assignRoleBtn',function(){
        var userid = $(this).attr('data-userid');
        var roleid = $(this).attr('data-roleid');
        var type = $(this).attr('data-type');
        $.ajax({
            type: "post",
            url: "{{route('user.assignrole')}}",
            data: {
                _token: '{{ csrf_token() }}',
                userid: userid,
                roleid: roleid,
                type: type
            },
            dataType: "json",
            success: function (response) {
                usertbl.ajax.reload();
            }
        });
    });

</script>
@endsection
