@extends('layout.admin.master')

@push('styles')
    <style>
        .img-prd{
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<section class="content-header">
    <h1>
        Danh sách sản phẩm
        <small> | bảng điều khiển</small>
    </h1>
    <ol class="breadcrumb">
        {{-- <li><a href=""><i class="fa fa-dashboard"></i>Home</a></li> --}}
        <li class="active">Sản phẩm</li>
    </ol>
</section>
<hr>
       
    <button class="btn btn-primary"><a href="{{  route('admin.products.addProduct') }}" style="color: #fff;">Create</a></button>
    <br>
    <br>
    <div class="text-end">
        <form method="GET" action="{{ route('admin.products.listProduct') }}" class="d-flex align-items-end">
            <div class="me-2"> <!-- Khoảng cách bên phải cho các input -->
                <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" value="{{ request('name') }}">
            </div>
            <div class="me-2">
                <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu" value="{{ request('min_price') }}">
            </div>
            <div class="me-2">
                <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="{{ request('max_price') }}">
            </div>
            <div class="me-2">
                <select name="category_id" class="form-control">
                    <option value="">Tất cả thể loại</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_category }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    
    
    
    <br>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Quantity</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listProduct as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->price }}</td>
                    <td>
                        <img class="img-prd" src="{{ asset($value->image) }}" alt="">
                    </td>
                    <td>{{ $value->quantity }}</td>
                    <td>{{ $value->category->name_category ?? 'No category' }}</td>

                    <td>
                        <button class="btn btn-success"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-info"><i class="fa-solid fa-circle-info"></i></button>
                        {{-- xóa mềm --}}
                        <form action="{{ route('admin.products.deleteProduct', $value->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                        </form>
                        {{-- xóa cứng --}}
                        <form action="{{ route('admin.products.hardDeleteProduct', $value->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa cứng không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-skull-crossbones"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $listProduct->links('pagination::bootstrap-5') }}
@endsection
