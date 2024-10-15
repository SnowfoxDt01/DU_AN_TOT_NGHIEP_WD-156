<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
            <li class="nav">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="nav-icon bi bi-person-lines-fill"></i>
                    <p>
                        Quản lí tài khoản
                    </p>
                </a>
            </li>
            <li class="nav">
                <a href="{{ route('admin.customers.index') }}" class="nav-link">
                    <i class="bi bi-person-vcard-fill"></i>
                    <p>
                        Quản lí khách hàng
                    </p>
                </a>
            </li>
            @role('super-admin')
            <li class="nav">
                <a href="{{ route('role-permission.index') }}" class="nav-link">
                    <i class="bi bi-grid-3x3"></i>
                    <p>
                        Bảng phân quyền
                    </p>
                </a>
            </li>
            @endrole
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                    <i class="nav-icon bi bi-list-task"></i>
                    <p>
                        Danh mục
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.listProduct') }}" class="nav-link">
                    <i class="nav-icon bi bi-bookmarks-fill"></i>
                    <p>
                        Sản phẩm
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="bi bi-receipt"></i>
                    <p>
                        Đơn hàng
                    </p>
                </a>
            </li>
            <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
