        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/dist/img/mainlogo.png') }}" style="height: 100px; width: 100%"
                            alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.users.index') }}" aria-expanded="false">
                                <i class="bi bi-person-lines-fill"></i>
                                <span class="hide-menu">Quản lý tài khoản</span>
                            </a>
                        </li>
                        @role('super-admin')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('role-permission.index') }}" aria-expanded="false">
                                    <i class="bi bi-grid-3x3"></i>
                                    <span class="hide-menu">Bảng phân quyền</span>
                                </a>
                            </li>
                        @endrole
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.categories.index') }}" aria-expanded="false">
                                <i class="bi bi-list-task"></i>
                                <span class="hide-menu">Quản lý danh mục</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.customers.index') }}" aria-expanded="false">
                                <i class="bi bi-person-vcard-fill"></i>
                                <span class="hide-menu">Quản lý khách hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.products.listProduct') }}"
                                aria-expanded="false">
                                <i class="bi bi-bookmarks-fill"></i>
                                <span class="hide-menu">Quản lý sản phẩm</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.variant-products.index') }}"
                                aria-expanded="false">
                                <i class="bi bi-gear-fill"></i>
                                <span class="hide-menu">Quản lý sản phẩm biến thể</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.colors.index') }}" aria-expanded="false">
                                <i class="bi bi-palette-fill"></i>
                                <span class="hide-menu">Quản lý màu sắc</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.sizes.index') }}" aria-expanded="false">
                                <i class="bi bi-rulers"></i>
                                <span class="hide-menu">Quản lý kích cỡ</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.orders.index') }}" aria-expanded="false">
                                <i class="bi bi-receipt"></i>
                                <span class="hide-menu">Quản lý dơn hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.payments.index') }}" aria-expanded="false">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="hide-menu">Quản lý hóa đơn</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.blogs.index') }}" aria-expanded="false">
                                <i class="bi bi-newspaper"></i>
                                <span class="hide-menu">Quản lý bài viết</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.banners.index') }}" aria-expanded="false">
                                <i class="bi bi-images"></i>
                                <span class="hide-menu">Banner</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.vouchers.index') }}" aria-expanded="false">
                                <i class="bi bi-ticket-perforated"></i>
                                <span class="hide-menu">Quản lý mã giảm giá</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
