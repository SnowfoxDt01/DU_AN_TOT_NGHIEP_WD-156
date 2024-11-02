<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn Thanh toán</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Hóa đơn Thanh toán của khách hàng "{{ $payment->order->customer->name }}"</h1>

    <p><strong>Mã hóa đơn:</strong> {{ $payment->id }}</p>
    <p><strong>Mã đơn hàng:</strong> {{ $payment->order->id }}</p>
    <p><strong>Khách hàng:</strong> {{ $payment->order->customer->name }}</p>
    <p><strong>Email:</strong> {{ $payment->order->customer->email }}</p>
    <p><strong>Số điện thoại:</strong> {{ $payment->order->customer->phone }}</p>
    <p><strong>Tổng tiền thanh toán:</strong> 
        {{ number_format($payment->order->items->sum(function ($item) {
            return $item->product->sale_price * $item->quantity;
        }), 0, ',', '.') }} VNĐ
    </p>
    <p><strong>Phương thức thanh toán:</strong> {{ ucfirst(App\Enums\PaymentMethod::getDescription($payment->order->payment_method)) }}</p>
    <p><strong>Ngày thanh toán:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $payment->order->shipping_address }}</p> <!-- Thêm địa chỉ giao hàng -->

    <h4>Thông tin sản phẩm:</h4>
    <table>
        <thead>
            <tr>                       
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Màu</th>
                <th>Kích cỡ</th>
                <th>Đơn giá</th>
                <th>Tổng giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->variantProducts->first()?->color->name ?? 'Không có màu'  }}</td>
                    <td>{{ $item->product->variantProducts->first()?->size->name ?? 'Không có màu'  }}</td>
                    <td>{{ number_format($item->product->sale_price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($item->quantity * $item->product->sale_price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
