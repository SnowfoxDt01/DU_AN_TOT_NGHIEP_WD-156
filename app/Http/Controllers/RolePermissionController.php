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
        // Gán nhiều quyền cho vai trò
        $role->syncPermissions($request->permissions); // sync để thay thế các quyền hiện có bằng những quyền mới
        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }
}
