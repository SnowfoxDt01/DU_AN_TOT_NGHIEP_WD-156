@extends('layout.ad.master')

@section('content')
    <div class="container">
        <div class="card card-body">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Thêm kích thước</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                        Thêm kích thước
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
                <form action="{{ route('admin.sizes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên Kích Thước</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('admin.sizes.index') }}" class="btn btn-light">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
@endsection
