    <!-- Header area start here -->
    <div class="top__header pt-30 pb-30">
        <div class="container">
            <div class="top__wrapper">
                <a href="#" class="main__logo">
                    <img src="client_ui/assets/images/logo/mainlogo.png"
                        style="max-width: 100%;height: auto; max-height: 100px; padding-bottom: 30px" alt="logo__image">
                </a>
                <div class="search__wrp">
                    <input placeholder="Search for" aria-label="Search">
                    <button><i class="fa-solid fa-search"></i></button>
                </div>
                <div class="account__wrap">
                </div>
            </div>
        </div>
    </div>
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="main-menu">
                    <li>
                        <a href="{{ route('client.index') }}">Trang chủ</a>
                    </li>
                    <li>
                        <a href="">Danh mục <i class="fa-regular fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            @foreach ($categories as $category)
                                <li class="subtwohober">
                                    <a href="#">
                                        {{ $category->name_category }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>

                    </li>
                    <li>
                        <a href="#0">Pages <i class="fa-regular fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            <li class="subtwohober">
                                <a href="shop.html">
                                    Shop Leftbar
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="shop-2.html">
                                    Shop Rightbar
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="shop-single.html">
                                    Shop Single
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="cart.html">
                                    Cart Page
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="checkout.html">
                                    Checkout Page
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="register.html">
                                    Register
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="login.html">
                                    Login
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="error.html">
                                    404 Error
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">Blog <i class="fa-regular fa-angle-down"></i></a>
                        <ul class="sub-menu">
                            <li class="subtwohober">
                                <a href="blog.html">
                                    Blog Stander
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="blog-grid.html">
                                    Blog Grid
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="blog-list.html">
                                    Blog List
                                </a>
                            </li>
                            <li class="subtwohober">
                                <a href="blog-single.html">
                                    Blog Single
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Giới thiệu</a>
                    </li>
                </ul>
                <div class="shipping__item d-none d-sm-flex align-items-center">
                    <div class="cart d-flex align-items-center">
                        <span class="cart__icon" style="margin-right: 10px">
                            <i class="fa-regular fa-cart-shopping"></i>
                        </span>
                        <a href="#0" class="c__one">
                            <span>
                                $0.00
                            </span>
                        </a>
                        <span class="one">
                            0
                        </span>
                    </div>
                    @if (Auth::check())
                        <div class="d-flex align-items-center">
                            <span style="color: orangered; margin-right: 10px;">
                                {{ Auth::user()->name }} |
                            </span>
                            <a href="{{ route('client.logout') }}" style="color: orangered">Đăng Xuất</a>
                        </div>
                    @else
                        <div class="account d-flex align-items-center">
                            <div class="user__icon" style="margin-right: 10px">
                                <a href="#0">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                            </div>
                            <a href="{{ route('client.login') }}" class="acc__cont">
                                <span style="color: orangered">Đăng nhập</span>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </header>
    <!-- Header area end here -->
