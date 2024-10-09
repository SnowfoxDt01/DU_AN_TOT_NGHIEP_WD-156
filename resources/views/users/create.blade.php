<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới tài khoản</title>
</head>
<body>
<form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="">Tên</label>
        <input type="text" name="name">
    </div>
    <div>
        <label for="">Email</label>
        <input type="email" name="email">
    </div>
    <div>
        <label for="">Mật khẩu</label>
        <input type="password" name="password">
    </div>
    <button type="submit">Thêm</button>
</form>
</body>
</html>