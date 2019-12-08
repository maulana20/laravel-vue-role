<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
	function __construct()
	{
		$this->middleware('permission:role-list', ['only' => ['page','pluck','add']]);
		$this->middleware('permission:role-create', ['only' => ['create','add','permission']]);
		$this->middleware('permission:role-edit', ['only' => ['edit','update','permission']]);
		$this->middleware('permission:role-delete', ['only' => ['destroy']]);
	}
	
	public function page(Request $request)
	{
		$roles = Role::orderBy('id','DESC')->paginate(5);
		
		return response()->json($roles, 200);
	}
	
	public function pluck(Request $request)
	{
		$roles = Role::pluck('name','id')->all();
		
		return response()->json($roles, 200);
	}
	
	public function add(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:roles,name',
			'permission' => 'required',
		]);
		
		$role = Role::create(['name' => $request->name]);
		$role->syncPermissions($request->permission);
		
		return response()->json($role, 200);
	}
	
	public function edit($id)
	{
		$role = Role::find($id);
		$access = DB::table("role_has_permissions")
			->where("role_has_permissions.role_id", $id)
			->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
			->all();
		
		return response()->json(['role' => $role, 'access' => $access], 200);
	}
	
	public function update($id, Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'permission' => 'required',
		]);
		
		$role = Role::find($id);
		$role->name = $request->input('name');
		$role->save();
		
		$role->syncPermissions($request->input('permission'));
		
		return response()->json($role, 200);
	}
	
	public function delete($id)
	{
		DB::table("roles")->where('id',$id)->delete();
		
		return redirect()->action('RoleController@page');
	}
	
	public function permission(Request $request)
	{
		$permission = Permission::get();
		
		return response()->json($permission, 200);
	}
}
