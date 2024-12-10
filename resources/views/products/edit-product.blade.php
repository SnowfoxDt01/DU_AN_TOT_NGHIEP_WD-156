@extends('layout.ad.master')

@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .meta-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .meta-box-header {
            cursor: pointer;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            padding: 10px;
            border-radius: 8px;
        }

        .variant {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            background-color: #fff;
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('content')
    <section class="content-header">
        <h1>
            Sửa sản phẩm
            <small>Trang chủ |</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Sửa sản phẩm</li>
        </ol>
    </section>

    <hr>
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.products.updateProduct', $product->id) }}" class="row g-3" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="meta-box">
                    <h3>Thông tin chung</h3>
                    <div class="form-group">
                        <label for="nameSP">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="nameSP" name="nameSP"
                            value="{{ $product->name }}">
                        @error('nameSP')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="priceSP">Giá</label>
                            <input type="number" class="form-control" id="priceSP" name="priceSP"
                                value="{{ $product->base_price }}">
                            @error('priceSP')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sale_price">Giá khuyến mãi</label>
                            <input type="number" class="form-control" id="sale_price" name="sale_price"
                                value="{{ $product->sale_price }}">
                            @error('sale_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="flash_sale_price">Giá siêu khuyến mãi</label>
                            <input type="number" class="form-control" id="flash_sale_price" name="flash_sale_price"
                                value="{{ $product->flash_sale_price }}">
                            @error('flash_sale_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descriptionSP">Mô tả</label>
                        <textarea class="form-control" id="descriptionSP" name="descriptionSP">{{ $product->description }}</textarea>
                        @error('descriptionSP')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_new">Trạng thái sản phẩm</label>
                        <select class="form-control" id="product_new" name="product_new">
                            <option value="0" {{ $product->new == 0 ? 'selected' : '' }}>Hàng trong kho</option>
                            <option value="1" {{ $product->new == 1 ? 'selected' : '' }}>Hàng mới</option>
                        </select>
                    </div>
                </div>

                <div class="meta-box">
                    <h3>Hình ảnh</h3>
                    <div class="form-group">
                        <label for="imageSP">Hình ảnh</label>
                        <input type="file" class="form-control" id="imageSP" name="imageSP[]" multiple>
                        @error('images')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <!-- Hiển thị các ảnh từ bảng images -->
                        @if ($product->images->count() > 0)
                            @foreach ($product->images as $image)
                                <img src="{{ asset($image->image_path) }}" alt="Product Image" class="img-preview mt-3"
                                    width="300">
                            @endforeach
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </div>
                </div>


                <h3>Biến thể</h3>
                <div class="meta-box">
                    <div id="variant-container">
                        @if ($product->variantProducts && $product->variantProducts->count() > 0)
                            @foreach ($product->variantProducts as $index => $variant)
                                <div class="variant">
                                    <div class="meta-box-header">
                                        <h3>{{ $variant->name }} <i class="fas fa-angle-down"></i></h3>
                                    </div>
                                    <div class="row g-3">
                                        <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">
                                        <div class="form-group col-md-4">
                                            <label for="variant_name">Tên sản phẩm biến thể</label>
                                            <input type="text" class="form-control" name="variant_name[]"
                                                value="{{ $variant->name }}" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="variant_quantity">Số lượng</label>
                                            <input type="number" class="form-control" name="variant_quantity[]"
                                                value="{{ $variant->quantity }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="variant_size">Kích cỡ</label>
                                            <select name="variant_size[]" class="form-control">
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ $size->id == $variant->size_id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="variant_image">Ảnh biến thể</label>
                                            <input type="file" class="form-control" name="variant_image[]" multiple>

                                            <!-- Hiển thị các ảnh từ bảng images -->
                                            @if ($variant->images->count() > 0)
                                                @foreach ($variant->images as $image)
                                                    <img src="{{ asset($image->image_path) }}" alt="Variant Image"
                                                        class="img-preview mt-3" width="300">
                                                @endforeach
                                            @else
                                                <span>Không có ảnh</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="variant_color">Màu</label>
                                            <select name="variant_color[]" class="form-control">
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}"
                                                        {{ $color->id == $variant->color_id ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="variant_status">Trạng thái</label>
                                            <select name="variant_status[]" class="form-control">
                                                <option value="active"
                                                    {{ $variant->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                                <option value="inactive"
                                                    {{ $variant->status == 'inactive' ? 'selected' : '' }}>Không hoạt động
                                                </option>
                                            </select>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <p>Không có biến thể nào cho sản phẩm này.</p>
                        @endif
                    </div>
                </div>

                <div class="meta-box">
                    <div class="form-group">
                        <label for="number-of-variants">Số lượng biến thể muốn thêm:</label>
                        <input type="number" id="number-of-variants" min="1" value="1"
                            class="form-control">
                        <button type="button" id="add-variants" class="btn btn-success mt-2">Thêm biến thể</button>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.products.listProduct') }}" class="btn btn-secondary">Trở về</a>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="meta-box">
                <h3>Danh mục sản phẩm</h3>
                <div class="form-group">
                    <label for="product_category_idSP">Danh mục</label>
                    <select class="form-control" id="product_category_idSP" name="product_category_idSP">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $product->product_category_id ? 'selected' : '' }}>
                                {{ $category->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ủy quyền sự kiện click cho .meta-box-header
            $('#variant-container').on('click', '.meta-box-header', function() {
                $(this).next('.row.g-3').toggle();
            });

            // Ủy quyền sự kiện click cho nút xóa biến thể (đã có sẵn)
            $('#variant-container').on('click', '.delete-variant', function() {
                $(this).closest('.variant').remove();
            });

            $('#add-variants').click(function() {
                const numberOfVariants = $('#number-of-variants').val();
                const variantContainer = $('#variant-container');
                for (let i = 0; i < numberOfVariants; i++) {
                    const newVariantHtml = `
                <div class="variant">
                    <div class="meta-box-header">
                        <h3>Biến thể mới ${i + 1} <i class="fas fa-angle-down"></i></h3>
                    </div>
                    <div class="row g-3">
                        <input type="hidden" name="variant_id[]" value="">
                        <div class="form-group col-md-4">
                            <label for="variant_name">Tên sản phẩm biến thể</label>
                            <input type="text" class="form-control" name="variant_name[]" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="variant_quantity">Số lượng</label>
                            <input type="number" class="form-control" name="variant_quantity[]" required>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="variant_size">Kích cỡ</label>
                            <select name="variant_size[]" class="form-control">
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="variant_color">Màu</label>
                            <select name="variant_color[]" class="form-control">
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="variant_image">Ảnh biến thể</label>
                            <input type="file" class="form-control" name="variant_image[]">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="variant_status">Trạng thái</label>
                            <select name="variant_status[]" class="form-control">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                        <hr>
                    </div>
                    <button type="button" class="btn btn-danger delete-variant">Xóa biến thể</button>
                </div>
                <hr>
            `;
                    variantContainer.append(newVariantHtml);

                    // *** Phần thay đổi ở đây ***
                    // Khởi tạo lại sự kiện click cho nút xóa biến thể (mới thêm)
                    $('.delete-variant').click(function() {
                        $(this).closest('.variant').remove();
                    });
                }
            });

            // Ẩn nội dung biến thể ban đầu (chỉ áp dụng cho các biến thể có sẵn)
            $('.variant .row.g-3').hide();
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#descriptionSP'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
