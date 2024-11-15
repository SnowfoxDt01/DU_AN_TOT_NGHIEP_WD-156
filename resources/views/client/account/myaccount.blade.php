@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt pb">
        <hr>
        <h2>Tài khoản của tôi</h2>
    </section>
    <hr>
    <section class="cart-page pt-130 pb-130">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4" style="margin-right: 50px">
                    <div class="product__left-item sub-bg">
                        <ul class="nav flex-column" id="accountTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" style="color: #fff" id="account-tab" data-bs-toggle="tab"
                                    href="#account" role="tab" aria-controls="account" aria-selected="true">
                                    <i class="bi bi-person-vcard" style="font-size: 20px;"> </i> Tài khoản</a>
                            </li>
                            <hr>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff;" id="warranty-tab" data-bs-toggle="tab"
                                    href="#warranty" role="tab" aria-controls="warranty" aria-selected="false">
                                    <i class="bi bi-shield-check" style="font-size: 20px;"> </i> Tra cứu bảo hành
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="order-history-tab" data-bs-toggle="tab"
                                    href="#order-history" role="tab" aria-controls="order-history"
                                    aria-selected="false">
                                    <i class="bi bi-receipt" style="font-size: 20px;"> </i> Lịch sử mua hàng
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="update-info-tab" data-bs-toggle="tab"
                                    href="#update-info" role="tab" aria-controls="update-info" aria-selected="false">
                                    <i class="bi bi-person-gear" style="font-size: 20px;"> </i> Thay đổi thông tin
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="support-tab" data-bs-toggle="tab"
                                    href="#support" role="tab" aria-controls="support" aria-selected="false">
                                    <i class="bi bi-headset" style="font-size: 20px;"> </i> Hỗ trợ
                                </a>
                            </li>
                            <hr>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('client.logout') }}" style="color: #fff">
                                    <i class="bi bi-box-arrow-left" style="font-size: 20px;"> </i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="tab-content" id="accountTabsContent">
                        <!-- Account Tab Content -->
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <p style="text-align: center;">
                                <i class="bi bi-person-circle" style="font-size: 50px;"></i>
                            </p>
                            <p style="text-align: center;">
                                {{ Auth::user()->name }}
                            </p>
                            <hr>
                            @if (Auth::user()->customer)
                                <div class="row">
                                    <div>
                                        <p><strong>Họ và Tên : </strong> {{ Auth::user()->customer->first()->name }}</p>
                                    </div>
                                    <hr>
                                    <div>
                                        <p><strong>Email : </strong> {{ Auth::user()->customer->first()->email }}</p>
                                    </div>
                                    <hr>
                                    <div>
                                        <p><strong>Số điện thoại :</strong> {{ Auth::user()->customer->first()->phone }}</p>
                                    </div>
                                    <hr>
                                    <div>
                                        <p><strong>Địa chỉ : </strong> {{ Auth::user()->customer->first()->address }}</p>
                                    </div>
                                    <hr>
                                    <div>
                                        <p> <strong>Ngày tham gia : </strong>
                                            {{ Auth::user()->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <hr>
                                    <div>
                                        <p><strong>Tổng số đơn hàng đã đặt: </strong> {{ Auth::user()->orders()->count() }}
                                        </p>
                                    </div>
                                    <hr>
                                </div>
                            @else
                                <p>Không có thông tin.</p>
                            @endif
                        </div>
                        <!-- Warranty Tab Content -->
                        <div class="tab-pane fade" id="warranty" role="tabpanel" aria-labelledby="warranty-tab">
                            <h4>Tra cứu bảo hành</h4>
                            <p>Nhập mã bảo hành để kiểm tra thông tin tại đây.</p>
                        </div>
                        <!-- Order History Tab Content -->
                        <div class="tab-pane fade" id="order-history" role="tabpanel" aria-labelledby="order-history-tab">
                            <h4>Lịch Sử Mua Hàng của: {{ Auth::user()->name }}</h4>
                            <hr>
                            <div class="d-flex mb-4">
                                <input type="date" style="background-color: black; color: #fff" class="form-control me-2" placeholder="Từ ngày" value="2020-12-01">
                                <input type="date" style="background-color: black; color: #fff" class="form-control" placeholder="Đến ngày" value="2024-11-06">
                            </div>
                            <div class="mb-4">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                                            data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                            aria-selected="true" style="color: #fff"><span>Tất cả</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab"
                                            data-bs-target="#pending" type="button" role="tab"
                                            aria-controls="pending" style="color: #fff" aria-selected="false"><span>Chờ xác
                                                nhận</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" style="color: #fff" id="confirmed-tab"
                                            data-bs-toggle="tab" data-bs-target="#confirmed" type="button"
                                            role="tab" aria-controls="confirmed" aria-selected="false"><span>Đã xác
                                                nhận</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" style="color: #fff" id="shipping-tab"
                                            data-bs-toggle="tab" data-bs-target="#shipping" type="button"
                                            role="tab" aria-controls="shipping" aria-selected="false"><span>Đang vận
                                                chuyển</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" style="color: #fff" id="delivered-tab"
                                            data-bs-toggle="tab" data-bs-target="#delivered" type="button"
                                            role="tab" aria-controls="delivered" aria-selected="false"><span>Đã giao
                                                hàng</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" style="color: #fff" id="cancelled-tab"
                                            data-bs-toggle="tab" data-bs-target="#cancelled" type="button"
                                            role="tab" aria-controls="cancelled" aria-selected="false"><span>Đã
                                                hủy</span></button>
                                    </li>
                                </ul>

                                <!-- Tab Contents -->
                                <div class="tab-content mt-3" id="orderTabContent">
                                    <!-- All Orders -->
                                    <div class="tab-pane fade show active" id="all" role="tabpanel"
                                        aria-labelledby="all-tab">
                                        <div class="card mb-3">
                                            @if ($orders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($orders as $order)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        <img src="{{$order->items->first()->product->images->first()->image_path}}"
                                                            alt="Hình Ảnh Sản Phẩm" class="me-3" style="width: 80px;">
                                                        <div class="flex-grow-1">
                                                            @if ($order->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $order->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount = $order->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                <small>
                                                                    Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái: 
                                                                    {{ App\Enums\OrderStatus::getDescription($order->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($order->items->sum(function ($item) { 
                                                                    // Lấy giá từ bảng product
                                                                    $product = $item->product;
                                                                    $price = $product->sale_price ? $product->sale_price : $product->base_price;
                                                                    return $item->quantity * $price;
                                                                }), 0, ',', '.') }} VND
                                                            </div>
                                                            <div class="mt-4 d-flex">
                                                                <a href="#" class="text-secondary me-2">Xem Hóa Đơn</a>
                                                                <a href="#" class="text-secondary">Xem Chi Tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Pending Orders -->
                                    <div class="tab-pane fade" id="pending" role="tabpanel"
                                        aria-labelledby="pending-tab">
                                        <p>Chờ xác nhận - Hiển thị các đơn hàng ở trạng thái "Chờ xác nhận".</p>
                                    </div>

                                    <!-- Confirmed Orders -->
                                    <div class="tab-pane fade" id="confirmed" role="tabpanel"
                                        aria-labelledby="confirmed-tab">
                                        <p>Đã xác nhận - Hiển thị các đơn hàng ở trạng thái "Đã xác nhận".</p>
                                    </div>

                                    <!-- Shipping Orders -->
                                    <div class="tab-pane fade" id="shipping" role="tabpanel"
                                        aria-labelledby="shipping-tab">
                                        <p>Đang vận chuyển - Hiển thị các đơn hàng ở trạng thái "Đang vận chuyển".</p>
                                    </div>

                                    <!-- Delivered Orders -->
                                    <div class="tab-pane fade" id="delivered" role="tabpanel"
                                        aria-labelledby="delivered-tab">
                                        <p>Đã giao hàng - Hiển thị các đơn hàng ở trạng thái "Đã giao hàng".</p>
                                    </div>

                                    <!-- Cancelled Orders -->
                                    <div class="tab-pane fade" id="cancelled" role="tabpanel"
                                        aria-labelledby="cancelled-tab">
                                        <p>Đã hủy - Hiển thị các đơn hàng ở trạng thái "Đã hủy".</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Update Info Tab Content -->
                        <div class="tab-pane fade" id="update-info" role="tabpanel" aria-labelledby="update-info-tab">
                            <div class="col-lg-12">

                                <div class="checkout__item-left sub-bg">
                                    <h3 class="mb-40">Thay đổi thông tin</h3>
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="mb-10" for="name">Họ *</label>
                                                <input class="mb-20" id="name" type="text">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-10" for="name">Tên *</label>
                                                <input class="mb-20" id="name" type="text">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-10" for="email">Email *</label>
                                                <input class="mb-20" id="email" type="email">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-10" for="phone">Số điện thoại *</label>
                                                <input class="mb-20" id="phone" type="text">
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-10">Chọn tỉnh / Thành phố *</h5>
                                                <select class="mb-20" name="subject">
                                                    <option value="0">United state america</option>
                                                    <option value="1">United Kingdom</option>
                                                    <option value="2">Australia</option>
                                                    <option value="3">Germany</option>
                                                    <option value="4">France</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-10">Chọn Quận / Huyện *</h5>
                                                <select class="mb-20" name="subject">
                                                    <option value="0">United state america</option>
                                                    <option value="1">United Kingdom</option>
                                                    <option value="2">Australia</option>
                                                    <option value="3">Germany</option>
                                                    <option value="4">France</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-10">Chọn Phường / Xã *</h5>
                                                <select class="mb-20" name="subject">
                                                    <option value="0">United state america</option>
                                                    <option value="1">United Kingdom</option>
                                                    <option value="2">Australia</option>
                                                    <option value="3">Germany</option>
                                                    <option value="4">France</option>
                                                </select>
                                            </div>
                                            <label class="mb-10" for="streetAddress">Địa chỉ cụ thể *</label>
                                            <input class="mb-20" id="streetAddress2" type="text">
                                        </div>
                                        <button type="submit" class="btn-one mt-35">Xác nhận thay đổi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Support Tab Content -->
                        <div class="tab-pane fade" id="support" role="tabpanel" aria-labelledby="support-tab">
                            <h4>Hỗ trợ</h4>
                            <p>Liên hệ với đội ngũ hỗ trợ của chúng tôi.</p>
                        </div>
                        <!-- Logout Tab Content -->
                        <div class="tab-pane fade" id="logout" role="tabpanel" aria-labelledby="logout-tab">
                            <h4>Đăng Xuất</h4>
                            <p>Đăng xuất khỏi tài khoản của bạn tại đây.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
