<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    // Hiển thị danh sách kích thước
    public function index()
    {
        $sizes = Size::paginate(5);
        return view('sizes.index', compact('sizes'));
    }

    // Hiển thị form tạo mới kích thước
    public function create()
    {
        return view('sizes.create');
    }

    // Lưu kích thước mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes',
        ]);

        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được tạo thành công.');
    }

    // Hiển thị form chỉnh sửa kích thước
    public function edit(Size $size)
    {
        return view('sizes.edit', compact('size'));
    }

    // Cập nhật kích thước trong cơ sở dữ liệu
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
        ]);

        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được cập nhật thành công.');
    }

    // Xóa kích thước khỏi cơ sở dữ liệu
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công.');
    }
}
