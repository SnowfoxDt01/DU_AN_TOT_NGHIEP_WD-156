@extends('layout.ad.master')

@section('content')
    <div class="container">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chỉnh sửa kích thước</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                        Chỉnh sửa kích thước
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
                <form action="{{ route('admin.sizes.update', $size) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên Kích Thước</label>
                        <input type="text" name="name" class="form-control" value="{{ $size->name }}" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="{{ route('admin.sizes.index') }}" class="btn btn-light">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
@endsection
