<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->input('keyword');
            $query->where('name_category', 'LIKE', "%{$keyword}%");
        }

        $status = $request->input('status');
        if ($status !== null) {
            $query->where('status', $status);
        }

        $categories = $query->paginate(5);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $fileName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('public/client_ui/assets/images/category'), $fileName);
                $imagePath = 'client_ui/assets/images/category/' . $fileName;
            }
        }

        Category::create([
            'name_category' => $request->name_category,
            'image' => $imagePath,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Tạo mới danh mục thành công.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = DB::table('product_categories')->where('id', $id)->first();
        return view('categories.edit', compact('category', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        // Xử lý upload ảnh nếu có ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($category->image) {
                Storage::delete(public_path($category->image));
            }

            // Di chuyển file đến thư mục client_ui/assets/images/category
            $fileName = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('client_ui/assets/images/category'), $fileName);
            $imagePath = 'client_ui/assets/images/category/' . $fileName;
        } else {
            // Nếu không có ảnh mới, giữ nguyên ảnh cũ
            $imagePath = $category->image;
        }

        // Cập nhật thông tin danh mục
        $category->update([
            'name_category' => $request->name_category,
            'image' => $imagePath,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục được cập nhật thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Xóa danh mục thành công.');
    }
}
