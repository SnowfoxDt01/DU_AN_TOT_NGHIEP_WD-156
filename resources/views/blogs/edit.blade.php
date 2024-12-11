@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chỉnh sửa bài viết</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chỉnh sửa bài viết
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <form action="{{ route('admin.blogs.update', $blog->id) }}" class="row g-3" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-md-6">
                    <label for="title">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control" value="{{ $blog->title }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description" class="form-control">{{ $blog->description }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-12">
                    <label for="content">Nội dung</label>
                    <textarea name="content" id="content" class="form-control">{{ $blog->content }}</textarea>
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
                        <option value="0" {{ $blog->status == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                        <option value="1" {{ $blog->status == '1' ? 'selected' : '' }}>Hoạt động</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sửa</button>
                </div>
            </form>
        </div>
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
