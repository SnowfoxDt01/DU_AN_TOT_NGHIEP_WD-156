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
                            <h2 class="text-white mb-65">Đặt lại mật khẩu</h2>
                            <div class="form-area login__form">
                                <form action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <input type="text" name="email" placeholder="Nhập email..."
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="password" name="password" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <input class="mt-30" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu...">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <button class="mt-30" type="submit">Đặt lại mật khẩu</button>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login area end here -->
@endsection