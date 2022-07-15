@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Roles</div>

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

                        </td>
                    </tr>
                    @endforeach
                   </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Permissions</div>

                <div class="card-body">
                   content
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
@endsection

