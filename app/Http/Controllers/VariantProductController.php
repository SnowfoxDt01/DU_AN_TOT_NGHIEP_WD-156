<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VariantProduct;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class VariantProductController extends Controller
{
    public function index(Request $request){
        
        $query = VariantProduct::with('category', 'size', 'color');

        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        // Lọc theo màu
        if ($request->filled('color_id')) {
            $query->where('color_id', $request->color_id);
        }
    
        // Lọc theo kích cỡ
        if ($request->filled('size_id')) {
            $query->where('size_id', $request->size_id);
        }
    
        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        $variantProducts = $query->get();
    
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
    
        return view('variant_products.index', compact('variantProducts', 'categories', 'sizes', 'colors'));
    }

    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('variant_products.create', compact('categories', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $linkImage = '';
        if($request->hasFile('image_url')){
            $image = $request->file('image_url');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);

            $linkImage = $linkStorage . $newName;
        }
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'image_url' => $linkImage,
            'status' => $request->status,
            'created_at' => Carbon::now()
        ];

        VariantProduct::create($data);
        return redirect()->route('admin.variant-products.index')->with('success', 'Sản phẩm biến thể đã được thêm thành công.');
    }

    public function edit($id)
    {
        $variantProduct = VariantProduct::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('variant_products.edit', compact('variantProduct', 'categories', 'sizes', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $variantProduct = VariantProduct::findOrFail($id);

        $linkImage = $variantProduct->image_url;
        if($request->hasFile('image_url')){
            $image = $request->file('image_url');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);
    
            $linkImage = $linkStorage . $newName;
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'image_url' => $linkImage,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ];

        $variantProduct->update($data);
        return redirect()->route('admin.variant-products.index')->with('success', 'Sản phẩm biến thể đã được cập nhật.');
    }

    public function destroy($id)
    {
        $variantProduct = VariantProduct::findOrFail($id);
        $variantProduct->delete();
        return redirect()->route('admin.variant-products.index')->with('success', 'Sản phẩm biến thể đã được xóa.');
    }
    public function show($id)
    {
        $variantProduct = VariantProduct::with('category', 'size', 'color')->findOrFail($id);
        return view('variant_products.show', compact('variantProduct'));
    }

    public function statistics(){
        $totalProducts = VariantProduct::count(); // Tổng số sản phẩm
        $totalCategories = Category::count(); // Tổng số danh mục
        $totalSizes = Size::count(); // Tổng số kích cỡ
        $totalColors = Color::count(); // Tổng số màu sắc

        // Tính số lượng sản phẩm theo từng danh mục
        $productsByCategory = VariantProduct::select('category_id', DB::raw('count(*) as count'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Tính số lượng sản phẩm theo từng màu
        $productsByColor = VariantProduct::select('color_id', DB::raw('count(*) as count'))
            ->groupBy('color_id')
            ->with('color')
            ->get();

        // Tính số lượng sản phẩm theo từng kích cỡ
        $productsBySize = VariantProduct::select('size_id', DB::raw('count(*) as count'))
            ->groupBy('size_id')
            ->with('size')
            ->get();

        return view('variant_products.statistics', compact('totalProducts', 'totalCategories', 'totalSizes', 'totalColors', 'productsByCategory', 'productsByColor', 'productsBySize'));
    }


}
