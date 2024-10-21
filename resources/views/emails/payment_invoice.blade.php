
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Hóa đơn</title>
</head>
<body>
    <h1>Xin chào {{ $payment->order->customer->name }},</h1>
    <p>Hóa đơn mua hàng của bạn được đính kèm trong email này.</p>
</body>
</html>
