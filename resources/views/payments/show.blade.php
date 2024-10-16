@extends('layout.admin.master')

@section('content')
    <h1>Chi tiết Hóa đơn Thanh toán</h1>

    <div class="card">
        <div class="card-header">
            <h3>Hóa đơn: {{ $payment->id }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Mã đơn hàng:</strong> {{ $payment->order->id }}</p>
            <p><strong>Khách hàng:</strong> {{ $payment->order->customer->name }}</p>
            <p><strong>Tổng tiền thanh toán:</strong> {{ number_format($payment->order->total_price, 0, ',', '.') }} VNĐ</p>
            <p><strong>Phương thức thanh toán:</strong> {{ ucfirst(App\Enums\PaymentMethod::getDescription($payment->order->payment_method)) }}</p></p>
            <p><strong>Ngày thanh toán:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.payments.export', $payment->id) }}" class="btn btn-primary">Xuất PDF</a>
            <a href="{{ route('admin.payments.sendEmail', $payment->id) }}" class="btn btn-success">Gửi hóa đơn qua Email</a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
