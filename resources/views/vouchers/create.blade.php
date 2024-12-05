@extends('layout.admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Tạo mới mã giảm giá
        </h1>
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> |
            <li class="active">Tạo mới mã giảm giá</li>
        </ol>
    </section>
    <hr>
    <div class="border border-3 p-4 rounded">
        <form action="{{ route('admin.vouchers.store') }}" class="row g-3" method="POST">
            @csrf
            <div class="form-group col-md-4">
                <label for="code">Mã giảm giá</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                @error('code')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="discount">Giảm giá</label>
                <input type="text" name="discount" class="form-control" value="{{ old('discount') }}">
                @error('discount')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="usage_limit">Lượt sử dụng giới hạn</label>
                <input type="text" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                @error('usage_limit')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="discount_type">Loại giảm giá</label>
                <select name="discount_type" id="discount_type" class="form-control">
                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm theo giá cố định
                    </option>
                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Giảm theo phần
                        trăm</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="expiry_date">Ngày hết hạn</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                @error('expiry_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control">
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Dừng hoạt động</option>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="expiry_date">Mô tả</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
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
