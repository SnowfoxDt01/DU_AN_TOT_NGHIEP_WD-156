@extends('layout.admin.master')

@section('content')
<div class="container">
    <h1>Quản lý màu sắc</h1>
    <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">Thêm màu mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Tên màu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($colors as $color)
                <tr>
                    <td>{{ $color->name }}</td>
                    <td>
                        <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
