@extends('layout.admin.master')

@section('content')
<div class="container">
    <h1>Sửa màu: {{ $color->name }}</h1>
    <form action="{{ route('admin.colors.update', $color) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên màu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $color->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
