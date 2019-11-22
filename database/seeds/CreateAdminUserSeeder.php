<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
	public function run()
	{
		$user = User::create([
			'name' => 'Admin',
			'email' => 'admin@test.com',
			'password' => Hash::make('admin')
		]);
		
		$role = Role::create(['name' => 'Admin']);
		
		$permissions = Permission::pluck('id','id')->all();
		
		$role->syncPermissions($permissions);
		
		$user->assignRole([$role->id]);
	}
}
