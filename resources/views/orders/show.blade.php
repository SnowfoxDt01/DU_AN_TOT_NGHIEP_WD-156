@extends('layout.admin.master')

@section('content')
    <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>

    <p>Khách hàng: {{ $order->customer->name }}</p>
    <p>Tổng tiền: {{ $order->total_price }}</p>
    <p>Phương thức thanh toán:<td>{{ ucfirst(App\Enums\PaymentMethod::getDescription($order->payment_method)) }}</td>
    </p>
    <p>Trạng thái: {{ App\Enums\OrderStatus::getDescription($order->order_status) }}</p>

    <h2>Sản phẩm trong đơn hàng</h2>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} - Số lượng: {{ $item->quantity }} - Giá: {{ $item->price }}</li>
        @endforeach
    </ul>

    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="order_status">Cập nhật trạng thái:</label>
        <select name="order_status">
            @foreach (App\Enums\OrderStatus::getValues() as $value)
            <option value="{{ $value }}" {{ $order->order_status == $value ? 'selected' : '' }}>
                {{ App\Enums\OrderStatus::getDescription($value) }}
            </option>
        @endforeach
        </select>
        <button type="submit">Cập nhật</button>
    </form>
    
@endsection
