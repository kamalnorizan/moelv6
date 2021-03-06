<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Passport\Token as ClientToken;
use Auth;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('users.index',compact('roles','permissions'));
    }

    public function ajaxloadusers(Request $request)
    {
        $users = User::with('roles','permissions');
        $roles = Role::all();
        $permissions = Permission::all();
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function (User $user){
                $roles ='';
                foreach($user->roles as $role){
                    $roles.='<button class="badge badge-primary removerole" data-roleid="'.$role->name.'" data-type="role" data-userid="'.$user->id.'">'.$role->name.'</button> ';
                }

                return $roles;
            })
            ->addColumn('permission', function(User $user){
                $permissions ='';
                foreach($user->permissions as $permission){
                    $permissions.='<button class="badge badge-warning removerole" data-roleid="'.$permission->name.'" data-type="permission" data-userid="'.$user->id.'">'.$permission->name.'</button> ';
                }

                return $permissions;
            })
            ->addColumn('action', function(User $user) use ($roles, $permissions){
                $roleBtns='';
                foreach ($roles as $key => $role) {
                    $roleBtns.='<a type="button" class="dropdown-item assignRoleBtn" data-userid="'.$user->id.'" data-type="role" data-roleid="'.$role->name.'" >'.$role->name.'</a>';
                }

                $permissionBtns='';
                foreach ($permissions as $key => $permission) {
                    $permissionBtns.='<a type="button" class="dropdown-item assignRoleBtn" data-userid="'.$user->id.'" data-type="permission" data-roleid="'.$permission->name.'" >'.$permission->name.'</a>';
                }

                $button = '<div class="dropdown">'.
                    '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton">'.
                    $roleBtns.
                    '<div class="dropdown-divider"></div>'.
                    $permissionBtns.
                    '</div>'.
                '</div>';
                return $button;
            })
            ->rawColumns(['role','permission','action'])
            ->make(true);
    }

    public function rolesStore (Request $request)
    {
        Role::create(['name'=>$request->roleName]);
        flash('Role created successfully')->success()->important();
        return redirect()->back();
    }

    public function assignrole(Request $request)
    {
        $user = User::find($request->userid);
        if($request->type=='role'){
            $user->assignRole($request->roleid);
        }else{
            $user->givePermissionTo($request->roleid);
        }

        return response()->json(['status'=>'success']);
    }

    public function removerole(Request $request)
    {
        $user = User::find($request->userid);
        if($request->type=='role'){
            $user->removeRole($request->roleid);
        }else{
            $user->revokePermissionTo($request->roleid);
        }

        return response()->json(['status'=>'success']);
    }

    public function rolesRemove($role)
    {
        Role::find($role)->delete();
        flash('Role deleted successfully')->error()->important();
        return redirect()->back();
    }

    public function assignpermission(Request $request)
    {
        $role = Role::find($request->role);
        $permission = Permission::find($request->permission);
        // return response()->json($request->assign);
        if($request->assign=="true"){
            $role->givePermissionTo($request->permission);
        }else{
            $role->revokePermissionTo($request->permission);
        }
        $data['permissions']=$role->permissions;
        $data['status']='success';
        return response()->json($data);
    }

    public function permissionStore(Request $request)
    {
        Permission::create(['name'=>$request->permissionName]);
        flash('Permission created successfully')->success()->important();
        return redirect()->back();
    }

    public function ssoLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user){
            $request->session()->put('email',$request->email);
            if($request->roles!=null){
                $roles = explode('|',$request->roles);
                $request->session()->put('roles',$roles);
            }

            Auth::loginUsingId($user->id);

            return redirect('home');
        }else{
            return redirect('login');
        }
    }

    public function getTokens()
    {
        $tokens = Auth::user()->tokens->where('revoked',0);
        return response()->json($tokens);
    }

    public function destroyToken($token_id)
    {
        $token = ClientToken::find($token_id)->revoke();
        return redirect()->back();
    }
}
