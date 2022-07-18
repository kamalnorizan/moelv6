@extends('layouts.app')

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
                        <td>
                            {{$role->permissions}}
                        </td>
                        <td>

                            <a href="{{route('user.role.remove',['role'=>$role->id])}}" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
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
        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                   content
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
@endsection
