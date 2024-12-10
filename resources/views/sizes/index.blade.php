@extends('layout.ad.master')

@section('content')
    <div class="container">
        <h1>Quản lý Kích Thước</h1>
        <hr>
        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Thêm Kích Thước</a>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->name }}</td>
                        <td>
                            <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" style="display:inline;">
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
