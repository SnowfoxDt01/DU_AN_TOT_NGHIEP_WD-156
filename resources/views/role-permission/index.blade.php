@extends('layout.ad.master')
@section('content')
    <div class="container">
        <section class="content-header">
            <h1>
                Bảng phân quyền
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
                <li class="active">Bảng phân quyền</li>
            </ol>
        </section>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h3>Tạo chức vụ</h3>
                <hr>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="role_name">Nhập tên chức vụ:</label>
                        <input type="text" name="role_name" id="role_name" class="form-control">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Tạo</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Tạo quyền</h3>
                <hr>
                <form action="{{ route('permissions.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên Quyền:</label>
                        <input type="text" class="form-control" name="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Thêm Quyền</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h3>Phân quyền cho tài khoản</h3>
                <br>
                <form action="{{ route('role-permission.assignRole') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user">Chọn tài khoản</label>
                        <select name="user_id" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="roles">Chọn chức vụ</label>
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input"
                                    id="role-{{ $role->id }}">
                                <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Hoàn thành</button>
                </form>
            </div>

            <div class="col-md-6">
                <h3>Phân quyền cho từng chức vụ</h3>
                <br>
                <form action="{{ route('role-permission.assignPermission') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="role">Chọn chức vụ</label>
                        <select name="role_id" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="permissions">Chọn quyền</label>
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="form-check-input" id="permission-{{ $permission->id }}">
                                <label class="form-check-label"
                                    for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Hoàn thành</button>
                </form>
            </div>
        </div>
    </div>
@endsection
