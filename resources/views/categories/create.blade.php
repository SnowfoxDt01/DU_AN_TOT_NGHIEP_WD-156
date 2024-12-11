@extends('layout.ad.master')
@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Thêm mới danh mục</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Thêm mới danh mục
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.categories.store') }}" class="row g-3" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="name_category">Tên danh mục</label>
                <input type="text" name="name_category" class="form-control" value="{{ old('name_category') }}">
                @error('name_category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Dừng hoạt động</option>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Ảnh danh mục</label>
                <input type="file" name="image" class="form-control">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
    </script>
@endpush
