<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Hash;

class UserController extends Controller
{
	public function page(Request $request)
	{
		$data = User::with('roles')->orderBy('users.id', 'DESC')->paginate(5);
		
		return response()->json($data, 200);
	}
	
	public function add(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|same:confirm-password',
			'role' => 'required'
		]);
		
		$user = User::create([ 'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password) ]);
		
		$user->assignRole($request->role);
		
		return response()->json($user, 200);
	}
	
	public function edit($id)
	{
		$user = User::with('roles')->find($id);
		
		return response()->json($user, 200);
	}
	
	public function update($id, Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required',
			'role' => 'required'
		]);
		
		$user = User::find($id);
		$user->update([ 'name' => $request->name, 'email' => $request->email ]);
		
		$user->assignRole($request->role);
		
		return response()->json($user, 200);
	}
	
	public function delete($id)
	{
		$user = User::find($id)->delete();
		
		return response()->json($user, 200);
	}
}
