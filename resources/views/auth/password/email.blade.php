@extends('layout.client.auth')
@section('content')
    <!-- Login area start here -->
    <section class="login-area pt-130 pb-130">
        <div class="container">
            @if (session('status'))
                <p>{{ session('status') }}</p>
            @endif
            <div class="login__item">
                <div class="row g-4">
                    <div class="col-xxl-8">
                        <div class="login__image">
                            <img src="client_ui/assets/images/banner/log.jpg" alt="image">
                        </div>
                    </div>
                    <div class="col-xxl-4">
                        <div class="login__content">
                            <h2 class="text-white mb-65">Quên mật khẩu</h2>
                            <div class="form-area login__form">
                                <form action="{{ route('password.email') }}" method="POST">
                                    @csrf
                                    <input type="text" name="email" placeholder="Nhập email..."
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <button type="submit" class="mt-30">Gửi liên kết nhận mật khẩu</button>
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
