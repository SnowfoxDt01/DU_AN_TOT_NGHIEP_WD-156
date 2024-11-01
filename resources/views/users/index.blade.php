@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách tài khoản
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Danh sách tài khoản</li>
        </ol>
    </section>
    <hr>
    <button class="btn btn-primary"><a href="{{ route('admin.users.create') }}" style="color: #fff;">Thêm</a></button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
                <th scope="col">Lịch sử mua hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->status == 0)
                            <span class="badge bg-red">Dừng hoạt động</span>
                        @elseif($user->status == 1)
                            <span class="badge bg-green">Đang hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}">
                            <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}"><button class="btn btn-primary">
                            <i class="fa-solid fa-circle-info"></i>
                        </button></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
