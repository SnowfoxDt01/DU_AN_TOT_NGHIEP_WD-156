@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Chỉnh sửa danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Chỉnh sửa danh mục</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('categories.update', $category->id) }}" method="POST" >
        @csrf
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" name="name_category" value="{{$category->name_category}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <input type="text" name="description" value="{{$category->description}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Sửa</button>
        </div>
    </form>
@endsection
