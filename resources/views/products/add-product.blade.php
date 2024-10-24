@extends('layout.admin.master')
@section('content')
<div class="container">
    <section class="content-header">
        <h1>
            Tạo mới sản phẩm
        </h1>
        <ol class="breadcrumb">
            {{-- <li><a href=""><i class="fa fa-dashboard"></i>Trang chủ</a></li> | --}}
            <li class="active">Tạo mới sản phẩm</li>
        </ol>
    </section>
    <hr>
    <form action="{{ route('admin.products.addPostProduct') }}" class="row g-3" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Thông tin sản phẩm chính</h3>
        <div class="form-group col-md-4">
            <label for="nameSP">Tên sản phẩm</label>
            <input type="text" class="form-control" name="nameSP" placeholder="Tên sản phẩm" required>
        </div>

        <div class="form-group col-md-4">
            <label for="priceSP">Giá</label>
            <input type="number" class="form-control" name="priceSP" placeholder="Giá sản phẩm" required>
        </div>
        <div class="form-group col-md-4">
            <label for="priceSP">Giá khuyến mãi</label>
            <input type="number" class="form-control" name="sale_price" placeholder="Giá sản phẩm" required>
        </div>

        <div class="form-group">
            <label for="descriptionSP">Mô tả</label>
            <textarea name="descriptionSP" class="form-control" placeholder="Mô tả sản phẩm"></textarea>
        </div>


        <div class="form-group col-md-4">
            <label for="imageSP">Ảnh sản phẩm</label>
            <input type="file" class="form-control" name="imageSP" placeholder="Hình ảnh sản phẩm" required>
        </div>
        <div class="form-group col-md-4">
            <label for="quantitySP">Số lượng</label>
            <input type="number" class="form-control" name="quantitySP" placeholder="Số lượng sản phẩm" required>
        </div>
        <div class="form-group col-md-4">
            <label for="quantitySP">Danh mục</label>
            <select name="product_category_idSP"  class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>
        
        <h3>Thông tin sản phẩm biến thể</h3>
        <div id="variant-container">
            <div class="variant row g-3">
                <div class="form-group col-md-4">
                    <label for="nameSP">Tên sản phẩm biến thể</label>
                    <input type="text" class="form-control" name="variant_name[]" placeholder="Tên biến thể" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="priceSP">Giá</label>
                    <input type="number" class="form-control" name="variant_price[]" placeholder="Giá biến thể" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="quantitySP">Số lượng</label>
                    <input type="number" class="form-control" name="variant_quantity[]" placeholder="Số lượng biến thể" required>
                </div>

                <div class="form-group">
                    <label for="descriptionSP">Mô tả</label>
                    <textarea name="variant_description[]" class="form-control" placeholder="Mô tả biến thể"></textarea>
                </div>

                <div class="form-group col-md-3">
                    <label for="variant_size[]">Kích cỡ</label>
                    <select name="variant_size[]" class="form-control">
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3" >
                    <label for="variant_color[]">Màu</label>
                    <select name="variant_color[]" class="form-control">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="variant_image">Ảnh biến thể</label>
                    <input type="file" class="form-control" name="variant_image[]" class="form-control">
                </div>
                <div class="form-group col-md-3" >
                    <label for="variant_status[]">Trạng thái</label>
                    <select name="variant_status[]" class="form-control">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>  
                <hr>                            
            </div>
        </div>

        <div class="form-group">
            <button type="button" id="add-variant" class="btn btn-primary">Thêm biến thể</button>
        
            <button type="submit" class="btn btn-success">Tạo sản phẩm</button>
        </div>

    </form>
    
    <script>
        document.getElementById('add-variant').addEventListener('click', function() {
            var container = document.getElementById('variant-container');
            var newVariant = document.createElement('div');
            newVariant.classList.add('variant');
            newVariant.innerHTML = `
                <div class="form-group">
                    <label for="nameSP">Tên sản phẩm biến thể</label>
                    <input type="text" class="form-control" name="variant_name[]" placeholder="Tên biến thể" required>
                </div>
                <div class="form-group">
                    <label for="descriptionSP">Mô tả</label>
                    <textarea name="variant_description[]" class="form-control" placeholder="Mô tả biến thể"></textarea>
                </div>
                <div class="form-group">
                    <label for="priceSP">Giá</label>
                    <input type="number" class="form-control" name="variant_price[]" placeholder="Giá biến thể" required>
                </div>
                <div class="form-group">
                    <label for="quantitySP">Số lượng</label>
                    <input type="number" class="form-control" name="variant_quantity[]" placeholder="Số lượng biến thể" required>
                </div>
                <div class="form-group">
                    <label for="variant_size[]">Kích cỡ</label>
                    <select name="variant_size[]" class="form-control">
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" >
                    <label for="variant_color[]">Màu</label>
                    <select name="variant_color[]" class="form-control">
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="variant_image">Ảnh biến thể</label>
                    <input type="file" class="form-control" name="variant_image[]" class="form-control">
                </div>
                <div class="form-group" >
                    <label for="variant_status[]">Trạng thái</label>
                    <select name="variant_status[]" class="form-control">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div> 
                <hr>
            `;
            container.appendChild(newVariant);
        });
    </script>
    
</div>
    
@endsection
