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

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function (User $user){
                $roles ='';
                foreach($user->roles as $role){
                    $roles.='<span class="badge badge-primary">'.$role->name.'</span> ';
                }

                return $roles;
            })
            ->addColumn('permission', function(User $user){
                $permissions ='';
                foreach($user->permissions as $permission){
                    $permissions.='<span class="badge badge-warning">'.$permission->name.'</span> ';
                }

                return $permissions;
            })
            ->addColumn('action', function(User $user){
                return 'Action';
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
