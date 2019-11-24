<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
	public function page(Request $request)
	{
		$data = User::with('roles')->orderBy('users.id', 'DESC')->paginate(5);
		
		return response()->json($data, 200);
	}
}
