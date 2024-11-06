@extends('layout.client.master')
@section('content')
    <section class="page-banner bg-image pt pb">
    </section>
    <section class="cart-page pt-130 pb-130">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4" style="margin-right: 50px">
                    <div class="product__left-item sub-bg">
                        <ul class="nav flex-column" id="accountTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" style="color: #fff" id="account-tab" data-bs-toggle="tab" href="#account"
                                    role="tab" aria-controls="account" aria-selected="true">
                                    <i class="bi bi-person-vcard"> </i> Tài khoản</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff;" id="warranty-tab" data-bs-toggle="tab" href="#warranty" role="tab"
                                    aria-controls="warranty" aria-selected="false">
                                    <i class="bi bi-shield-check"> </i> Tra cứu bảo hành
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="order-history-tab" data-bs-toggle="tab" href="#order-history"
                                    role="tab" aria-controls="order-history" aria-selected="false">
                                    <i class="bi bi-receipt"> </i> Lịch sử mua hàng
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="update-info-tab" data-bs-toggle="tab" href="#update-info"
                                    role="tab" aria-controls="update-info" aria-selected="false">
                                    <i class="bi bi-person-gear"> </i> Thay đổi thông tin
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" style="color: #fff" id="support-tab" data-bs-toggle="tab" href="#support" role="tab"
                                    aria-controls="support" aria-selected="false">
                                    <i class="bi bi-headset"> </i> Hỗ trợ
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('client.logout') }}" style="color: #fff">
                                    <i class="bi bi-box-arrow-left"> </i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="tab-content" id="accountTabsContent">
                        <!-- Account Tab Content -->
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h4>Tài Khoản</h4>
                            <p>Thông tin tài khoản của bạn sẽ hiển thị tại đây.</p>
                        </div>
                        <!-- Warranty Tab Content -->
                        <div class="tab-pane fade" id="warranty" role="tabpanel" aria-labelledby="warranty-tab">
                            <h4>Tra cứu bảo hành</h4>
                            <p>Nhập mã bảo hành để kiểm tra thông tin tại đây.</p>
                        </div>
                        <!-- Order History Tab Content -->
                        <div class="tab-pane fade" id="order-history" role="tabpanel" aria-labelledby="order-history-tab">
                            <h4>Lịch Sử Mua Hàng</h4>
                            <!-- Order History Content -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Lịch Sử Mua Hàng</h5>
                                <span>1 Đơn Hàng | 3M Tổng Tiền Tích Lũy</span>
                            </div>

                            <div class="d-flex mb-4">
                                <input type="date" class="form-control me-2" placeholder="Từ ngày" value="2020-12-01">
                                <input type="date" class="form-control" placeholder="Đến ngày" value="2024-11-06">
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-outline-secondary me-2">Tất cả</button>
                                <button class="btn btn-outline-secondary me-2">Chờ xác nhận</button>
                                <button class="btn btn-outline-secondary me-2">Đã xác nhận</button>
                                <button class="btn btn-outline-secondary me-2">Đang vận chuyển</button>
                                <button class="btn btn-danger me-2">Đã giao hàng</button>
                                <button class="btn btn-outline-secondary">Đã hủy</button>
                            </div>

                            <!-- Order Item -->
                            <div class="card mb-3">
                                <div class="card-body d-flex align-items-center">
                                    <img src="client_ui/assets/images/product-placeholder.png" alt="Hình Ảnh Sản Phẩm"
                                        class="me-3" style="width: 80px;">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">Màn Hình Gaming E-DRA EGM27F100 27 Inch</h5>
                                        <p class="mb-0">Và 1 Sản Phẩm Khác <span class="badge bg-danger">Đã Xuất
                                                VAT</span></p>
                                    </div>
                                    <div class="text-end">
                                        <div>2,739,000₫</div>
                                        <div class="mt-2">
                                            <a href="#" class="text-secondary me-2">Xem Hóa Đơn</a>
                                            <a href="#" class="text-secondary">Xem Chi Tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Update Info Tab Content -->
                        <div class="tab-pane fade" id="update-info" role="tabpanel" aria-labelledby="update-info-tab">
                            <h4>Thay Đổi Thông Tin</h4>
                            <p>Cập nhật thông tin cá nhân của bạn tại đây.</p>
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
