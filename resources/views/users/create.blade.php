@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Tạo mới tài khoản
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Tạo mới tài khoản</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('admin.users.store') }}" class="row g-3" method="POST">
        @csrf
        <div class="form-group col-md-4">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success col-md-1">Thêm</button>
    </form>
@endsection
