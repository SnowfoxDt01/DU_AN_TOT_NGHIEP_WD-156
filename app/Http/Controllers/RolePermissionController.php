<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('role-permission.index', compact('users', 'roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Tạo quyền thành công.');
    }


    public function assignRole(Request $request)
    {
        $user = User::find($request->user_id);
        // Gán nhiều vai trò cho người dùng
        $user->syncRoles($request->roles); // sync để thay thế các vai trò hiện có bằng những vai trò mới
        return redirect()->back()->with('success', 'Roles assigned successfully.');
    }

    public function assignPermission(Request $request)
    {
        $role = Role::find($request->role_id);

        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }
        
        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }
}
