@extends('layout.ad.master')

@section('content')
    <div class="container">
        <h1>Thêm Kích Thước</h1>
        <form action="{{ route('admin.sizes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Tên Kích Thước</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
