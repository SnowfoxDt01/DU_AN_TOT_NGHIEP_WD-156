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
    <p><strong>Tổng tiền thanh toán:</strong> {{ number_format($payment->order->total_price, 0, ',', '.') }} VNĐ</p>
    <p><strong>Phương thức thanh toán:</strong> {{ ucfirst(App\Enums\PaymentMethod::getDescription($payment->order->payment_method)) }}</p>
    <p><strong>Ngày thanh toán:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
</body>
</html>
