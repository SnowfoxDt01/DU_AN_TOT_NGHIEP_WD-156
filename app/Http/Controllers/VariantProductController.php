<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VariantProduct;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class VariantProductController extends Controller
{
    public function index(Request $request)
    {

        $query = VariantProduct::with('product', 'size', 'color');

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

        // Lọc theo sản phẩm chính
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $variantProducts = $query->paginate(10);

        $products = Product::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('variant_products.index', compact('variantProducts', 'products', 'sizes', 'colors'));
    }


    public function edit($id)
    {
        $variantProduct = VariantProduct::findOrFail($id);
        $products = Product::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('variant_products.edit', compact('variantProduct', 'products', 'sizes', 'colors'));
    }

    public function update(Request $request, $id)
    {
        $variantProduct = VariantProduct::findOrFail($id);

        // $linkImage = $variantProduct->image_url;
        // if($request->hasFile('image_url')){
        //     $image = $request->file('image_url');
        //     $newName = time() . '.' . $image->getClientOriginalExtension();
        //     $linkStorage = 'imageProducts/';
        //     $image->move(public_path($linkStorage), $newName);

        //     $linkImage = $linkStorage . $newName;
        // }

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'status' => $request->status,
            'updated_at' => Carbon::now()
        ];

        // Handle image upload and deletion
        if ($request->hasFile('image_path')) {
            // Delete all existing images for this variant product
            $variantProduct->images()->delete();

            // Upload new image and create a new record
            $image = $request->file('image_path');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);

            $variantProduct->images()->create([
                'image_path' => $linkStorage . $newName,
            ]);
        }

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
        $variantProduct = VariantProduct::with('product', 'size', 'color')->findOrFail($id);
        return view('variant_products.show', compact('variantProduct'));
    }

    public function statistics()
    {
        $totalVariantProducts = VariantProduct::count(); // Tổng số sản phẩm biến thể
        $totalCategories = Category::count(); // Tổng số sản phẩm chính
        $totalSizes = Size::count(); // Tổng số kích cỡ
        $totalColors = Color::count(); // Tổng số màu sắc

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

        // Tính số lượng sản phẩm theo trạng thái
        $productsByStatus = VariantProduct::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $categories = Category::all();
        return view('variant_products.statistics', compact('totalVariantProducts', 'totalCategories', 'totalSizes', 'totalColors', 'productsByColor', 'productsBySize', 'productsByStatus','categories'));
    }
}
