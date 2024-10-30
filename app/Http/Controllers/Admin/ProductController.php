<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Color;
use App\Models\Size;

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
            'product_category_id' => $request->product_category_idSP,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $product = Product::create($productData);

        // Thêm sản phẩm biến thể
        if ($request->has('variant_name') && !empty(array_filter($request->variant_name)))  {
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
                    'price' => $request->variant_price[$key],
                    'quantity' => $request->variant_quantity[$key],
                    'product_id' => $product->id, // Liên kết với sản phẩm chính
                    'size_id' => $request->variant_size[$key],
                    'color_id' => $request->variant_color[$key],
                    'image_url' => $linkImageVP, // Đường dẫn ảnh biến thể
                    'status' => $request->variant_status[$key],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
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
        $product = Product::with('variantProducts')->findOrFail($id);
        $sizes = Size::all(); // Lấy tất cả kích cỡ từ bảng sizes
        $colors = Color::all(); // Lấy tất cả màu từ bảng colors
        $categories = Category::all();
        return view('products.edit-product', compact('product', 'sizes', 'colors', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        // Tìm sản phẩm để cập nhật
        $product = Product::with('variantProducts')->findOrFail($id);
        
        // Xử lý hình ảnh
        $linkImage = $product->image; // Giữ lại hình ảnh cũ nếu không có hình ảnh mới
        if ($request->hasFile('imageSP')) {
            $image = $request->file('imageSP');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';

            // Xóa ảnh cũ nếu có
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $image->move(public_path($linkStorage), $newName);
            $linkImage = $linkStorage . $newName; // Cập nhật hình ảnh mới
        }

        // Cập nhật thông tin sản phẩm chính
        $product->update([
            'name' => $request->nameSP,
            'description' => $request->descriptionSP,
            'base_price' => $request->priceSP,
            'sale_price' => $request->sale_price,
            'image' => $linkImage,
            'quantity' => $request->quantitySP ?? $product->quantity,
            'product_category_id' => $request->product_category_idSP ?? $product->product_category_id,
            'updated_at' => Carbon::now()
        ]);

        // Cập nhật sản phẩm biến thể
        if ($request->has('variant_name')) {
            foreach ($request->variant_name as $key => $name) {
                // Kiểm tra xem variant_id có tồn tại hay không
                if (isset($request->variant_id[$key]) && $request->variant_id[$key] !== '') {
                    // Nếu có variant_id, cập nhật biến thể
                    $variantId = $request->variant_id[$key];
                    $variantProduct = VariantProduct::find($variantId);
                    
                    $linkImageVP = $variantProduct->image_url; // Giữ lại đường dẫn cũ nếu không có hình ảnh mới

                    if ($request->hasFile("variant_image.$key")) {
                        // Xóa ảnh cũ nếu có
                        if (File::exists(public_path($variantProduct->image_url))) {
                            File::delete(public_path($variantProduct->image_url));
                        }
                        $image = $request->file("variant_image.$key");
                        $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $linkStorage = 'imageProducts/';
                        $image->move(public_path($linkStorage), $newName);
                        $linkImageVP = $linkStorage . $newName;
                    }

                    $variantProduct->update([
                        'name' => $name,
                        
                        'price' => $request->variant_price[$key],
                        'quantity' => $request->variant_quantity[$key],
                        'product_id' => $product->id,
                        'size_id' => $request->variant_size[$key],
                        'color_id' => $request->variant_color[$key],
                        'image_url' => $linkImageVP,
                        'status' => $request->variant_status[$key],
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    // Nếu không có variant_id, tạo mới biến thể
                    $linkImageVP = ''; 

                    if ($request->hasFile("variant_image.$key")) {
                        $image = $request->file("variant_image.$key");
                        $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $linkStorage = 'imageProducts/';
                        $image->move(public_path($linkStorage), $newName);
                        $linkImageVP = $linkStorage . $newName;
                    }

                    VariantProduct::create([
                        'name' => $name,
                        
                        'price' => $request->variant_price[$key],
                        'quantity' => $request->variant_quantity[$key],
                        'product_id' => $product->id,
                        'size_id' => $request->variant_size[$key],
                        'color_id' => $request->variant_color[$key],
                        'image_url' => $linkImageVP,
                        'status' => $request->variant_status[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }     

        return redirect()->route('admin.products.listProduct')->with('success', 'Cập nhật sản phẩm thành công');
    }
    // Phương thức để tải lên hình ảnh biến thể
    public function uploadVariantImage($request, $key)
    {
        $image = $request->file("variant_image.$key");
        $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
        $linkStorage = 'imageProducts/';
        $image->move(public_path($linkStorage), $newName);
        return $linkStorage . $newName;
    }



    public function detailProduct($id)
    {
        // Lấy thông tin sản phẩm cùng với tên màu và kích thước của sản phẩm biến thể
        $product = Product::with([
            'category',
            'variantProducts' => function ($query) {
                $query->with([
                    'size:id,name',  // Lấy id và tên của size
                    'color:id,name'  // Lấy id và tên của color
                ]);
            },
            'reviews'
        ])->findOrFail($id);
        // Tính số lượng đánh giá
        $totalReviews = $product->reviews->count();

        // Tính điểm trung bình đánh giá
        $averageRating = $totalReviews > 0 ? $product->reviews->avg('rating') : 0;                              

        // Tăng số lượt xem lên 1
        $product->increment('views');
        // Trả về view chi tiết sản phẩm
        return view('products.detail-product', compact('product', 'totalReviews', 'averageRating'));
    }


    public function showReviews($id){
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->where('is_visible', true)->get(); // Chỉ lấy đánh giá hiển thị
        return view('products.detail-product', compact('product', 'reviews'));
    }

}
