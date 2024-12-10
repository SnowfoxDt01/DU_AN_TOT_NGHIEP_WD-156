@extends('layout.ad.master')

@push('styles')
    <style>
        .img-preview{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h1>Sửa sản phẩm biến thể</h1>

        <form action="{{ route('admin.variant-products.update', $variantProduct->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ $variantProduct->name }}" required>
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" name="quantity" class="form-control" value="{{ $variantProduct->quantity }}" required>
            </div>

            <div class="form-group">
                <label for="product_id">Sản phẩm chính</label>
                <select name="product_id" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $product->id == $variantProduct->product_id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image_path">Hình ảnh</label>
                <input type="file" class="form-control" id="image_path" name="image_path">
            
                <div class="mt-3">
                    @if ($variantProduct->images->count() > 0)
                        @foreach ($variantProduct->images as $image)
                            <img src="{{ asset($image->image_path) }}" alt="Ảnh biến thể" class="img-preview">
                        @endforeach
                    @else
                        <span>Không có ảnh</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="size_id">Kích cỡ</label>
                <select name="size_id" class="form-control" required>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}" {{ $size->id == $variantProduct->size_id ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="color_id">Màu sắc</label>
                <select name="color_id" class="form-control" required>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ $color->id == $variantProduct->color_id ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $variantProduct->status == 'active' ? 'selected' : '' }}>Còn hàng</option>
                    <option value="inactive" {{ $variantProduct->status == 'inactive' ? 'selected' : '' }}>Không còn hàng</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm biến thể</button>
        </form>
    </div>
@endsection
