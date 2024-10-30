@extends('layout.admin.master')

@section('content')
    <h1>Chi tiết Hóa đơn Thanh toán</h1>

    <div class="card">
        <div class="card-header">
            <h3>Mã hóa đơn: {{ $payment->id }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Mã đơn hàng:</strong> {{ $payment->order->id }}</p>
            <p><strong>Khách hàng:</strong> {{ $payment->order->customer->name }}</p>
            <p><strong>Email:</strong> {{ $payment->order->customer->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $payment->order->customer->phone }}</p>
            <p><strong>Tổng tiền thanh toán:</strong> {{ number_format($payment->order->total_price, 0, ',', '.') }} VNĐ</p>
            <p><strong>Phương thức thanh toán:</strong> {{ ucfirst(App\Enums\PaymentMethod::getDescription($payment->order->payment_method)) }}</p>
            <p><strong>Ngày thanh toán:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $payment->order->shipping_address }}</p> <!-- Thêm địa chỉ giao hàng -->
            
            <h4>Thông tin sản phẩm:</h4>
            <table class="table">
                <thead>
                    <tr>                       
                        <th>Tên sản phẩm</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tổng giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100px; height: auto;">
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.payments.export', $payment->id) }}" class="btn btn-primary">Xuất PDF</a>
            <a href="{{ route('admin.payments.sendEmail', $payment->id) }}" class="btn btn-success">Gửi hóa đơn qua Email</a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
