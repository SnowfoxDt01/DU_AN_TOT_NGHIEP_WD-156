@extends('layout.admin.master')

@section('content')
    <div class="container">
        <h1>Sửa Kích Thước</h1>
        <form action="{{ route('admin.sizes.update', $size) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên Kích Thước</label>
                <input type="text" name="name" class="form-control" value="{{ $size->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
