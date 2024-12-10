@extends('layout.ad.master')
@section('content')
    <section class="content-header">
        <h1>
            Tạo mới bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Tạo mới bài viết</li>
        </ol>
    </section>
    <hr>
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.blogs.store') }}" class="row g-3" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-6">
                <label for="title">Tiêu đề bài viết</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="content">Nội dung</label>
                <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
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
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Thêm</button>
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
