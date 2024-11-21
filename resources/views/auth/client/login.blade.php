@extends('layout.client.auth')
@section('content')
    <!-- Login area start here -->
    <section class="login-area pt-130 pb-130">
        <div class="container">
            <div class="login__item">
                <div class="row g-4">
                    <div class="col-xxl-8">
                        <div class="login__image">
                            <img src="client_ui/assets/images/banner/log.jpg" alt="image">
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="login__content">
                            <h2 class="text-white mb-65">Đăng nhập</h2>
                            <div class="form-area login__form">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <input type="text" name="email" placeholder="Nhập email..." value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="password" name="password" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <button class="mt-30">Đăng nhập</button>
                                    <hr>
                                </form>
                                <small>
                                    Bạn chưa có tài khoản? <a href="{{ route('register') }}"
                                        style="color: rgb(255, 110, 32);">Đăng kí tại đây!</a>
                                </small>
                                <span class="or pt-30 pb-40">Hoặc</span>
                            </div>
                            <div class="login__with">
                                <a href="#0"><img src="client_ui/assets/images/icon/google.svg" alt="">
                                    Đăng nhập bằng google</a>
                                <a class="mt-15" href="#0"><img src="client_ui/assets/images/icon/facebook.svg"
                                        alt="">
                                    Đăng nhập bằng facebook</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login area end here -->
@endsection
