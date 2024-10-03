<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách sản phẩm</title>
</head>
<body>
    <h1>XIn chào thế giới</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($listProduct as $value)
                <tr>
                    <td>{{ $value['id'] }}</td>
                    <td>{{ $value['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>