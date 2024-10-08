<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$user = User::find(2);
$user->assignRole('super-admin');

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Tạo các quyền (permissions)
    Permission::create(['name' => 'edit users']);
    Permission::create(['name' => 'delete users']);
    Permission::create(['name' => 'create users']);
    Permission::create(['name' => 'assign roles']);

    // Tạo vai trò (roles)
    $roleSuperAdmin = Role::create(['name' => 'super-admin']);
    $roleAdmin = Role::create(['name' => 'admin']);
    
    // Gán quyền cho vai trò
    $roleSuperAdmin->givePermissionTo(Permission::all()); // Super Admin có tất cả quyền
    $roleAdmin->givePermissionTo(['edit users', 'create users']); // Admin chỉ có một số quyền
    }
}
