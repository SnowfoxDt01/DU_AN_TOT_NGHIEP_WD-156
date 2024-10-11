@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Quản lí tài khoản
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Quản lí tài khoản</li>
        </ol>
    </section>
    <hr>
    <div>
        <button class="btn btn-primary"><a href="{{ route('users.create') }}" style="color: #fff;">Create</a></button>

        <div class="d-flex justify-content-end">
            <form action="{{ route('categories.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <div class="input-group mx-2">
                        <select name="status" class="form-control">
                            <option value="">--Lọc theo trạng thái--</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        </select>
                    </div>
                    <input type="text" name="keyword" class="form-control" placeholder="Nhập tên hoặc email..."
                        value="{{ request('keyword') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password }}</td>
                    <td>
                        @if ($user->status == 0)
                            <span class="badge bg-red">Dừng hoạt động</span>
                        @elseif($user->status == 1)
                            <span class="badge bg-green">Đang hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}">
                            <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
