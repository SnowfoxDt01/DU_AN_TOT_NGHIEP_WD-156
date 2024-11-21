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
                                <a class="nav-link" href="{{ route('logout') }}" style="color: #fff">
                                    <i class="bi bi-box-arrow-left" style="font-size: 20px;"> </i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="tab-content" id="accountTabsContent">
                        <!-- Account Tab Content -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
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
                        <div class="tab-pane fade" id="order-history" role="tabpanel"
                            aria-labelledby="order-history-tab">
                            <h4>Lịch Sử Mua Hàng của: {{ Auth::user()->name }}</h4>
                            <hr>
                            <div class="d-flex mb-4">
                                <input type="date" style="background-color: black; color: #fff"
                                    class="form-control me-2" placeholder="Từ ngày" value="2020-12-01">
                                <input type="date" style="background-color: black; color: #fff" class="form-control"
                                    placeholder="Đến ngày" value="2024-11-06">
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
                                            aria-controls="pending" style="color: #fff" aria-selected="false"><span>Chờ
                                                xác
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
                                        <button class="nav-link" style="color: #fff" id="completed-tab"
                                            data-bs-toggle="tab" data-bs-target="#completed" type="button"
                                            role="tab" aria-controls="completed" aria-selected="false"><span>Đã hoàn
                                                thành</span></button>
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
                                                        @if (
                                                            $order->items->isNotEmpty() &&
                                                                $order->items->first()->product &&
                                                                $order->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $order->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
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
                                                                {{ number_format($order->total_price, 0, ',', '.') }} VND
                                                            </div>
                                                            <div class="mt-4 d-flex">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $order->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                                @if (in_array($order->order_status, ['confirming', 'confirmed']) && $order->user_id == auth()->id())
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#cancelOrderModal"
                                                                        data-order-id="{{ $order->id }}">Hủy đơn
                                                                        hàng</button>
                                                                @endif
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
                                        <div class="card mb-3">
                                            @if ($confirmOrders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($confirmOrders as $confirm)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        @if (
                                                            $confirm->items->isNotEmpty() &&
                                                                $confirm->items->first()->product &&
                                                                $confirm->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $confirm->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            @if ($confirm->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $confirm->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount = $confirm->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                    <small>
                                                                        Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                    </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái:
                                                                    {{ App\Enums\OrderStatus::getDescription($confirm->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($confirm->total_price, 0, ',', '.') }} VND
                                                            </div>
                                                            <div class="mt-4 d-flex justify-content-start">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $confirm->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                                @if ($confirm->order_status !== 'canceled' && $confirm->user_id == auth()->id())
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#cancelOrderModal"
                                                                        data-order-id="{{ $confirm->id }}">Hủy đơn
                                                                        hàng</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Confirmed Orders -->
                                    <div class="tab-pane fade" id="confirmed" role="tabpanel"
                                        aria-labelledby="confirmed-tab">
                                        <div class="card mb-3">
                                            @if ($confirmedOrders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($confirmedOrders as $confirmed)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        @if (
                                                            $confirmed->items->isNotEmpty() &&
                                                                $confirmed->items->first()->product &&
                                                                $confirmed->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $confirmed->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            @if ($confirmed->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $confirmed->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount =
                                                                        $confirmed->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                    <small>
                                                                        Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                    </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái:
                                                                    {{ App\Enums\OrderStatus::getDescription($confirmed->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($confirmed->total_price, 0, ',', '.') }}
                                                                VND
                                                            </div>
                                                            <div class="mt-4 d-flex justify-content-start">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $confirmed->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                                @if ($confirmed->order_status !== 'canceled' && $confirmed->user_id == auth()->id())
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#cancelOrderModal"
                                                                        data-order-id="{{ $confirmed->id }}">Hủy đơn
                                                                        hàng</button>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Shipping Orders -->
                                    <div class="tab-pane fade" id="shipping" role="tabpanel"
                                        aria-labelledby="shipping-tab">
                                        <div class="card mb-3">
                                            @if ($shippingOrders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($shippingOrders as $shipping)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        @if (
                                                            $shipping->items->isNotEmpty() &&
                                                                $shipping->items->first()->product &&
                                                                $shipping->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $shipping->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            @if ($shipping->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $shipping->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount =
                                                                        $shipping->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                    <small>
                                                                        Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                    </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái:
                                                                    {{ App\Enums\OrderStatus::getDescription($shipping->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($shipping->total_price, 0, ',', '.') }}
                                                                VND
                                                            </div>
                                                            <div class="mt-4 d-flex">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $shipping->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Completed Orders -->
                                    <div class="tab-pane fade" id="completed" role="tabpanel"
                                        aria-labelledby="completed-tab">
                                        <div class="card mb-3">
                                            @if ($completedOrders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($completedOrders as $completed)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        @if (
                                                            $completed->items->isNotEmpty() &&
                                                                $completed->items->first()->product &&
                                                                $completed->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $completed->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            @if ($completed->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $completed->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount =
                                                                        $completed->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                    <small>
                                                                        Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                    </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái:
                                                                    {{ App\Enums\OrderStatus::getDescription($completed->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($completed->total_price, 0, ',', '.') }}
                                                                VND
                                                            </div>
                                                            <div class="mt-4 d-flex">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $completed->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Cancelled Orders -->
                                    <div class="tab-pane fade" id="cancelled" role="tabpanel"
                                        aria-labelledby="cancelled-tab">
                                        <div class="card mb-3">
                                            @if ($canceledOrders->isEmpty())
                                                <p>Không có đơn hàng nào.</p>
                                            @else
                                                @foreach ($canceledOrders as $canceled)
                                                    <div class="card-body d-flex align-items-center"
                                                        style="background-color: black ;color: white;">
                                                        @if (
                                                            $canceled->items->isNotEmpty() &&
                                                                $canceled->items->first()->product &&
                                                                $canceled->items->first()->product->images->isNotEmpty())
                                                            <img src="{{ $canceled->items->first()->product->images->first()->image_path }}"
                                                                alt="Hình Ảnh Sản Phẩm" class="me-3"
                                                                style="width: 80px;">
                                                        @else
                                                            <p>Không có ảnh </p>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            @if ($canceled->items->isNotEmpty())
                                                                <!-- Hiển thị sản phẩm đầu tiên trong đơn hàng -->
                                                                <h5 class="mb-1 text-truncate" style="max-width: 300px;">
                                                                    {{ $canceled->items->first()->product->name }}
                                                                </h5>
                                                                <!-- Hiển thị số sản phẩm còn lại trong đơn hàng -->
                                                                @php
                                                                    $remainingItemsCount =
                                                                        $canceled->items->count() - 1;
                                                                @endphp
                                                                @if ($remainingItemsCount > 0)
                                                                    <small>
                                                                        Và {{ $remainingItemsCount }} sản
                                                                        phẩm khác
                                                                    </small>
                                                                @endif
                                                                <p>
                                                                    Trạng thái:
                                                                    {{ App\Enums\OrderStatus::getDescription($canceled->order_status) }}
                                                                </p>
                                                            @else
                                                                <p>Không có sản phẩm nào trong đơn hàng này.</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <div>
                                                                {{ number_format($canceled->total_price, 0, ',', '.') }}
                                                                VND
                                                            </div>
                                                            <div class="mt-4 d-flex">
                                                                <a href="#" class="btn btn-orange me-2">Xem hóa
                                                                    đơn</a>
                                                                <a href="{{ route('client.order.detail', $canceled->id) }}"
                                                                    class="btn btn-orange me-2">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Update Info Tab Content -->
                        <div class="tab-pane fade" id="update-info" role="tabpanel" aria-labelledby="update-info-tab">
                            <div class="col-lg-12">
                                <div class="checkout__item-left sub-bg">
                                    <h3 class="mb-40">Thay đổi mật khẩu</h3>
                                    <form action="{{ route('client.myaccount.checkChangePassWord') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-10" for="current-password">Mật khẩu hiện tại *</label>
                                                <input class="mb-20" id="current-password" name="current_password"
                                                    type="password" required>
                                                @error('current-password')
                                                    <small class="help-block text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mb-10" for="new-password">Mật khẩu mới *</label>
                                                <input class="mb-20" id="new-password" name="new_password"
                                                    type="password" required>
                                                @error('new-password')
                                                    <small class="help-block text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mb-10" for="confirm-password">Xác nhận mật khẩu mới
                                                    *</label>
                                                <input class="mb-20" id="confirm-password" name="confirm_password"
                                                    type="password" required>
                                                @error('confirm-password')
                                                    <small class="help-block text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
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
    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: black; color: white;">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Lý do hủy đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cancelOrderForm" name="cancelOrderForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Lý do hủy</label>
                            <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- hết modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cancelOrderModal = document.getElementById('cancelOrderModal');
            cancelOrderModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute('data-order-id');
                var form = document.getElementById('cancelOrderForm');
                form.action = '/client/order/' + orderId + '/cancel';
            });
        });
    </script>

@endsection
