@extends('layout.client.auth')
@section('content')
    <!-- Login area start here -->
    <section class="login-area pt-130 pb-130">
        <div class="container">
            <div class="login__item">
                <div class="row g-4">
                    <div class="col-xxl-8">
                        <div class="login__image">
                            <img src="client_ui/assets/images/banner/regis.webp" alt="image">
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="login__content">
                            <h2 class="text-white mb-65">Đăng kí</h2>
                            <div class="form-area login__form">
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <input type="text" name="name" placeholder="Nhập tên người dùng..." value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="password" name="password" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="password"
                                        name="password_confirmation"placeholder="Nhập lại mật khẩu...">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <button class="mt-30">Đăng kí</button>
                                    <hr>
                                    <small>
                                        Bạn đã có tài khoản? <a href="{{ route('login') }}"
                                            style="color: rgb(255, 110, 32);">Đăng nhập tại đây!</a>
                                    </small>
                                </form>
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
