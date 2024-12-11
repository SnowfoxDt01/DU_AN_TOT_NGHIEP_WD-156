@extends('layout.ad.master')

@section('content')
    <div class="card card-body">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="fw-semibold fs-4 mb-4 mb-md-0 card-title">Chi tiết sản phẩm biến thể</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Chi tiết sản phẩm biến thể
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body p-3">
            <div class="container">
                <h2>{{ $variantProduct->name }}</h2>
                <div class="row">
                    <div class="col-md-6">
                        @if ($variantProduct->images->count() > 0)
                            @foreach ($variantProduct->images as $image)
                                <img src="{{ asset($image->image_path) }}" alt="Ảnh biến thể" class="img-prd"
                                    width="300px">
                            @endforeach
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p><strong>Mã sản phẩm biến thể:</strong> {{ $variantProduct->id }}</p>
                        <p><strong>Số lượng:</strong> {{ $variantProduct->quantity }}</p>
                        <p><strong>Nhãn hàng:</strong>
                            {{ $variantProduct->product->category->name_category ?? 'Không có nhãn hàng' }} </p>
                        <p><strong>Kích thước:</strong> {{ $variantProduct->size->name ?? 'Không có size' }} </p>
                        <p><strong>Màu sắc:</strong> {{ $variantProduct->color->name ?? 'Không có màu' }} </p>
                        <p><strong>Ngày tạo:</strong> {{ $variantProduct->created_at->format('d/m/Y') }}</p>
                        <p><strong>Ngày cập nhật:</strong> {{ $variantProduct->updated_at->format('d/m/Y') }}</p>
                        <p><strong>Trạng thái:</strong>
                            @if ($variantProduct->status == 'active')
                                <span>Còn hàng</span>
                            @else
                                <span>Không còn hàng</span>
                            @endif
                        </p>

                    </div>
                </div>
                <hr>
                <a href="{{ route('admin.variant-products.index') }}" class="btn btn-light">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
