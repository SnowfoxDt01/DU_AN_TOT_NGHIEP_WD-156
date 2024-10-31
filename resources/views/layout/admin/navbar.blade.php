<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a href="{{ route('client.index') }}" class="nav-link"><i class="bi bi-browser-chrome"> | Vào website</i></a>
        </li>

        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon flag-icon-us"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="{{ url('lang/en') }}" class="dropdown-item">
                    <i class="flag-icon flag-icon-us mr-2"></i> {{ __('English') }}
                </a>
                <a href="{{ url('lang/vi') }}" class="dropdown-item">
                    <i class="flag-icon flag-icon-vn mr-2"></i>{{ __('Vietnamese') }}
                </a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="orderNotificationDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="badge badge-danger" id="orderNotificationCount" style="display: none;"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="orderNotificationDropdown">
                <div id="newOrdersList"></div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" role="button">
                {{ Auth::user()->name }}
            </a>
        </li>

        <li class="nav-item">
            <div>
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="nav-icon bi bi-box-arrow-right"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
