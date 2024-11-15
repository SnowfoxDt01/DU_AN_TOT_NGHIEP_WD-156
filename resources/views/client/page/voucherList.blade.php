@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt-130 pb-130" data-background="assets/images/banner/inner-banner.jpg">
        <div class="container">
            <h2 class="wow fadeInUp mb-15" data-wow-duration="1.1s" data-wow-delay=".1s">Mã ưu đãi</h2>
            <div class="breadcrumb-list wow fadeInUp" data-wow-duration="1.3s" data-wow-delay=".3s">
                <a href="{{ route('client.index') }}" class="primary-hover"><i class="fa-solid fa-house me-1"></i> Trang chủ
                    <i class="fa-regular text-white fa-angle-right"></i></a>
                <span>Mã ưu đãi</span>
            </div>
        </div>
    </section>
    <hr>
    <section class="blog pt-130 pb-130">
        <div class="container">
            <div class="row g-4">
                @foreach ($vouchers as $voucher)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog__item-right">
                            <div>
                                <label for="">Mã giảm giá: </label>
                                <h3>{{ $voucher->code }}</h3    >
                                </h3>
                            </div>
                            <div>
                                <label for="">Mô tả: </label>
                                <h3><a href="">{{ $voucher->description }}</a>
                                </h3>
                            </div>
                            @if ($voucher->expiry_date != null)
                                <div class="d-flex align-items-center justify-content-between">
                                    <label for="">Ngày hết hạn:</label>
                                    <span>{{ $voucher->expiry_date }}</span>
                                </div>
                            @else
                                Không giới hạn
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-65">
                {{ $vouchers->links('pagination::custom') }}
            </div>
        </div>
    </section>
@endsection
