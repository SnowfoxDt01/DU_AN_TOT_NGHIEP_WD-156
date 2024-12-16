            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg  navbar-light">
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item">
                                <a href="{{ route('client.index') }}" class="nav-link"><i class="bi bi-browser-chrome" style="font-size: 15px">
                                        Vào website</i></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <iconify-icon icon="solar:bell-linear" class="fs-6"></iconify-icon>
                                    <span id="orderNotificationCount" class="badge bg-danger rounded-circle"
                                        style="display: none;"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="orderDropdown"
                                    id="newOrdersList">
                                    <p class="dropdown-item text-muted">Không có đơn hàng mới</p>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="src/assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle"> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Tài khoản</p>
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Đăng xuất</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
