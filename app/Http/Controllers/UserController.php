<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Passport\Token as ClientToken;
use Auth;
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

    public function rolesStore (Request $request)
    {
        Role::create(['name'=>$request->roleName]);
        flash('Role created successfully')->success()->important();
        return redirect()->back();
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
        if($request->assign){
            $role->givePermissionTo($request->permission);
        }else{
            $role->revokePermissionTo($permission->name);
        }

        return response()->json(['status'=>'success']);
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
