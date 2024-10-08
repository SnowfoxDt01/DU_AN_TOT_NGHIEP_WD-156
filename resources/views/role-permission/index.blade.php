@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Roles and Permissions</h1>

    <h3>Assign Role to User</h3>
    <form action="{{ route('role-permission.assignRole') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user">Select User</label>
            <select name="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="roles">Select Roles</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role-{{ $role->id }}">
                    <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
    
        <button type="submit" class="btn btn-primary">Assign Role</button>
    </form>
    

    <h3>Assign Permission to Role</h3>
    <form action="{{ route('role-permission.assignPermission') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Select Role</label>
            <select name="role_id" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="permissions">Select Permissions</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="permission-{{ $permission->id }}">
                    <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
    
        <button type="submit" class="btn btn-primary">Assign Permission</button>
    </form>    
</div>
@endsection
