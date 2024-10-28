@extends('layout.admin.master')

@push('styles')
    <style>
        .category-image {
            background-color: #7b7b7b; /* Màu xám nhạt */
            padding: 10px; /* Khoảng cách giữa ảnh và viền */   
        }
    </style>
@endpush

@section('content')
<section class="content-header">
    <h1>
        Danh sách danh mục
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
        <li class="active">Danh sách danh mục</li>
    </ol>
</section>
<hr>
<div>
    <button class="btn btn-primary"><a href="{{ route('admin.categories.create') }}"
            style="color: #fff;">Thêm</a></button>

    <div class="d-flex justify-content-end">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <div class="input-group mx-2">
                    <select name="status" class="form-control">
                        <option value="">--Lọc theo trạng thái--</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                    </select>
                </div>
                <input type="text" name="keyword" class="form-control" placeholder="Nhập tên danh mục..."
                    value="{{ request('keyword') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<hr>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name_category }}</td>
            <td >
                <img class="category-image" src="{{$category->image}}" alt="">
            </td>
            <td>{{ $category->description }}</td>
            <td>
                @if ($category->status == 0)
                <span class="badge bg-red">Dừng hoạt động</span>
                @elseif($category->status == 1)
                <span class="badge bg-green">Đang hoạt động</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}">
                    <button class="btn btn-success" style="display: inline-block;"><i class="bi bi-pencil-square"></i></button>
                </a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" ><i class="bi bi-trash3-fill"></i></button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
{{ $categories->links() }}
@endsection