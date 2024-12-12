<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::paginate(5); // Lấy tất cả màu sắc
        return view('colors.index', compact('colors'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors|max:255',
        ]);

        Color::create($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Màu đã được tạo thành công!');
    }

    public function edit(Color $color)
    {
        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|unique:colors,name,' . $color->id . '|max:255',
        ]);

        $color->update($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Màu đã được cập nhật thành công!');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Màu đã được xóa thành công!');
    }
}
