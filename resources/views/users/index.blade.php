@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Danh sách tài khoản</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Danh sách tài khoản
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="product-list">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center gap-6 mb-9">
                    <button class="btn btn-primary"><a href="{{ route('admin.users.create') }}"
                            style="color: #fff;">Thêm</a></button>
                </div>
                <div class="table-responsive border rounded">
                    <table class="table align-middle text-nowrap mb-0">
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
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-danger p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Dừng hoạt động</p>
                                            </div>
                                        @elseif($user->status == 1)
                                            <div class="d-flex align-items-center">
                                                <span class="text-bg-success p-1 rounded-circle"></span>
                                                <p class="mb-0 ms-2">Đang hoạt động</p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}">
                                            <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}"><button
                                                class="btn btn-primary">
                                                <i class="bi bi-clock-history"></i>
                                            </button></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="d-flex align-items-center justify-content-end py-1">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
