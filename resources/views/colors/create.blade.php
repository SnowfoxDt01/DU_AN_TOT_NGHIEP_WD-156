@extends('layout.admin.master')

@section('content')
<div class="container">
    <h1>Thêm màu mới</h1>
    <form action="{{ route('admin.colors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên màu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
