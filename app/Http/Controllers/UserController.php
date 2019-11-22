<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
	public function page(Request $request)
	{
		$data = User::orderBy('id','DESC')->paginate(5);
		return response()->json(['status' => 'success', 'list' => $data], 200);
	}
}
