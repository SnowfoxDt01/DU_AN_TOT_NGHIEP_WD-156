@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Sửa tài khoản</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Sửa tài khoản
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="form-group">
                    <label for="" class="form-label">Trạng thái</label>
                    <select name="status" id="" class="form-select">
                        <option {{ $user->status == 1 ? 'selected' : '' }} value="1">Đang hoạt động</option>
                        <option {{ $user->status == 0 ? 'selected' : '' }} value="0">Dừng hoạt động</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
