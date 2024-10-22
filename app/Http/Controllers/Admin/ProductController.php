<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function listProduct(Request $request)
    {
        $query = Product::with('category');

        // lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('base_price', [$request->min_price, $request->max_price]);
        } elseif ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        } elseif ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Lọc theo thể loại
        if ($request->filled('category_id')) {
            $query->where('product_category_id', $request->category_id);
        }

        $categories = \App\Models\Category::all();

        $listProduct = $query->paginate(5);
        return view('products.index')->with([
            'listProduct' => $listProduct,
            'categories' => $categories
        ]);
    }

    public function addProduct()
    {
        $categories = \App\Models\Category::all();
        $sizes = \App\Models\Size::all();
        $colors = \App\Models\Color::all();
        return view('products.add-product', compact('categories', 'sizes', 'colors'));
    }

    public function addPostProduct(Request $request)
    {
        // Thêm sản phẩm chính
        $linkImage = '';
        if ($request->hasFile('imageSP')) {
            $image = $request->file('imageSP');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);
            $linkImage = $linkStorage . $newName;
        }

        $productData = [
            'name' => $request->nameSP,
            'description' => $request->descriptionSP,
            'base_price' => $request->priceSP,
            'sale_price' => $request->sale_price,
            'image' => $linkImage,
            'quantity' => $request->quantitySP,
            'product_category_id' => $request->product_category_idSP
        ];
        $product = Product::create($productData);

        // Thêm sản phẩm biến thể
        if ($request->has('variant_name')) {
            foreach ($request->variant_name as $key => $name) {
                $linkImageVP = ''; // Đặt lại biến chứa đường dẫn ảnh cho từng biến thể

                // Kiểm tra xem có file ảnh nào cho biến thể không
                if ($request->hasFile("variant_image.$key")) {
                    $image = $request->file("variant_image.$key");
                    $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension(); // Đặt tên file khác nhau cho từng ảnh
                    $linkStorage = 'imageProducts/';
                    $image->move(public_path($linkStorage), $newName);
                    $linkImageVP = $linkStorage . $newName;
                }

                VariantProduct::create([
                    'name' => $name,
                    'description' => $request->variant_description[$key],
                    'price' => $request->variant_price[$key],
                    'quantity' => $request->variant_quantity[$key],
                    'product_id' => $product->id, // Liên kết với sản phẩm chính
                    'size_id' => $request->variant_size[$key],
                    'color_id' => $request->variant_color[$key],
                    'image_url' => $linkImageVP, // Đường dẫn ảnh biến thể
                    'status' => $request->variant_status[$key],
                ]);
            }
        }

        return redirect()->route('admin.products.listProduct')->with('success', 'Sản phẩm và sản phẩm biến thể đã được thêm thành công.');
    }


    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.listProduct');
    }

    public function hardDeleteProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete(); // Xóa cứng sản phẩm
        return redirect()->route('admin.products.listProduct');
    }
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit-product')->with('product', $product);
    }

    public function updateProduct(Request $req, $id)
    {
        $product = Product::findOrFail($id);

        $linkImage = $product->image;

        if($req->hasFile('imageSP')){
            File::delete(public_path($product->image));
            $image = $req->file('imageSP');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);

            $linkImage = $linkStorage . $newName;
        }

        // Cập nhật dữ liệu sản phẩm
        $data = [
            'name' => $req->nameSP,
            'description' => $req->descriptionSP,
            'base_price' => $req->priceSP,
            'sale_price' => $req->sale_price,
            'image' => $linkImage,
            'quantity' => $req->quantitySP,
            'product_category_id' => $req->product_category_idSP
        ];

        $product->update($data);

        return redirect()->route('admin.products.listProduct');
    }


    public function detailProduct($id)
    {
        // Lấy thông tin sản phẩm dựa trên ID
        $product = Product::with('category')->findOrFail($id);

        // Trả về view chi tiết sản phẩm
        return view('products.detail-product')->with('product', $product);
    }
}
