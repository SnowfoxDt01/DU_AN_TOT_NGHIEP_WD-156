@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Chỉnh sửa bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Chỉnh sửa bài viết</li>
        </ol>
    </section>
    <hr>
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" class="row g-3" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group col-md-6">
                <label for="title">Tiêu đề bài viết</label>
                <input type="text" name="title" class="form-control" value="{{$blog->title}}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control">{{$blog->description}}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="content">Nội dung</label>
                <textarea name="content" id="content" class="form-control">{{$blog->content}}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="image">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{$blog->status == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                    <option value="1" {{$blog->status == '1' ? 'selected' : '' }}>Hoạt động</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Sửa</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
