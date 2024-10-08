@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Phân Quyền</h1>

    <h3>Phân quyền cho tài khoản</h3>
    <form action="{{ route('role-permission.assignRole') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user">Chọn tài khoản</label>
            <select name="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="roles">Chọn chức vụ</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role-{{ $role->id }}">
                    <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
    
        <button type="submit" class="btn btn-primary">Hoàn thành</button>
    </form>
    

    <h3>Phân quyền cho từng chức vụ</h3>
    <form action="{{ route('role-permission.assignPermission') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Chọn chức vụ</label>
            <select name="role_id" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="permissions">Chọn quyền</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="permission-{{ $permission->id }}">
                    <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
    
        <button type="submit" class="btn btn-primary">Hoàn thành</button>
    </form>    
</div>
@endsection
