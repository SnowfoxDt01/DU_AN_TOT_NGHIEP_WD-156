<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Color;
use App\Models\Size;
use App\Models\Image;

class ProductController extends Controller
{
    public function listProduct(Request $request)
    {
        $query = Product::with('category', 'variantProducts', 'images');

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

        $listProduct = $query->paginate(10);

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

    public function addPostProduct(StoreProductRequest $request)
    {
        // Thêm sản phẩm chính
        $productData = [
            'name' => $request->nameSP,
            'description' => $request->descriptionSP,
            'base_price' => $request->priceSP,
            'flash_sale_price' => $request->flash_sale_price,
            'sale_price' => $request->sale_price,
            'new' => $request->product_new,
            'product_category_id' => $request->product_category_idSP,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $product = Product::create($productData);

        // Kiểm tra và lưu nhiều ảnh cho sản phẩm chính
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $linkStorage = 'imageProducts/';
                $image->move(public_path($linkStorage), $newName);
                $linkImage = $linkStorage . $newName;

                Image::create([
                    'product_id' => $product->id,
                    'image_path' => $linkImage,
                ]);
            }
        }

        // Thêm sản phẩm biến thể
        if ($request->has('variant_name') && !empty(array_filter($request->variant_name))) {
            foreach ($request->variant_name as $key => $name) {
                $sizeId = $request->variant_size[$key];
                $colorId = $request->variant_color[$key];

                // Kiểm tra xem biến thể với kích cỡ và màu sắc này đã tồn tại chưa
                $existingVariant = VariantProduct::where('product_id', $product->id)
                    ->where('size_id', $sizeId)
                    ->where('color_id', $colorId)
                    ->first();

                if (!$existingVariant) {
                    // Tạo sản phẩm biến thể nếu chưa tồn tại
                    $variant = VariantProduct::create([
                        'name' => $name,
                        'quantity' => $request->variant_quantity[$key],
                        'product_id' => $product->id,
                        'size_id' => $sizeId,
                        'color_id' => $colorId,
                        'status' => $request->variant_status[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Lưu một ảnh cho mỗi biến thể
                    if ($request->hasFile("variant_image.$key")) {
                        $image = $request->file("variant_image.$key");
                        $newName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $linkStorage = 'imageProducts/';
                        $image->move(public_path($linkStorage), $newName);
                        $linkImageVP = $linkStorage . $newName;

                        Image::create([
                            'product_variant_id' => $variant->id,
                            'image_path' => $linkImageVP,
                        ]);
                    }
                }
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

        // Cập nhật thông tin sản phẩm chính
        $product->update([
            'name' => $request->nameSP,
            'description' => $request->descriptionSP,
            'base_price' => $request->priceSP,
            'flash_sale_price' => $request->flash_sale_price,
            'sale_price' => $request->sale_price,
            'new' => $request->product_new,
            'product_category_id' => $request->product_category_idSP ?? $product->product_category_id,
            'updated_at' => Carbon::now()
        ]);

        // Xử lý hình ảnh sản phẩm
        if ($request->hasFile('imageSP')) {
            // Xóa ảnh cũ (nếu cần thiết) - Chỉ xóa khi có hình ảnh mới được upload
            if ($product->images()->exists()) {
                foreach ($product->images as $oldImage) {
                    $imagePath = public_path($oldImage->image_path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Xóa file ảnh
                    }
                    $oldImage->delete(); // Xóa bản ghi trong bảng images
                }
            }

            // Lưu ảnh mới
            foreach ($request->file('imageSP') as $image) {
                $newName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images/products/' . $newName;
                $image->move(public_path('images/products'), $newName);

                // Tạo bản ghi ảnh mới trong bảng images
                Image::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }




        // Cập nhật sản phẩm biến thể
        if ($request->has('variant_name')) {
            foreach ($request->variant_name as $key => $name) {
                // Kiểm tra xem variant_id có tồn tại hay không
                if (isset($request->variant_id[$key]) && $request->variant_id[$key] !== '') {
                    // Nếu có variant_id, cập nhật biến thể
                    $variantId = $request->variant_id[$key];
                    $variantProduct = VariantProduct::find($variantId);
        
                    $variantProduct->update([
                        'name' => $name,
                        'quantity' => $request->variant_quantity[$key],
                        'product_id' => $product->id,
                        'size_id' => $request->variant_size[$key],
                        'color_id' => $request->variant_color[$key],
                        'status' => $request->variant_status[$key],
                        'updated_at' => Carbon::now()
                    ]);
        
                    // Xử lý hình ảnh biến thể
                    if ($request->hasFile("variant_image.$key")) {
                        // Xóa ảnh cũ trong bảng images (nếu có)
                        foreach ($variantProduct->images as $oldImage) {
                            if (File::exists(public_path($oldImage->image_path))) {
                                File::delete(public_path($oldImage->image_path)); // Xóa file ảnh
                            }
                            $oldImage->delete(); // Xóa bản ghi trong bảng images
                        }
        
                        // Lưu ảnh mới vào bảng images
                        $image = $request->file("variant_image.$key");
                        $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $linkStorage = 'imageProducts/';
                        $image->move(public_path($linkStorage), $newName);
                        $imagePath = $linkStorage . $newName;
        
                        // Tạo bản ghi ảnh mới trong bảng images
                        Image::create([
                            'product_variant_id' => $variantId,
                            'image_path' => $imagePath,
                        ]);
                    }
        
                } else {
                    // Nếu không có variant_id, tạo mới biến thể
                    $variantProduct = VariantProduct::create([
                        'name' => $name,
                        'quantity' => $request->variant_quantity[$key],
                        'product_id' => $product->id,
                        'size_id' => $request->variant_size[$key],
                        'color_id' => $request->variant_color[$key],
                        'status' => $request->variant_status[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
        
                    // Lưu ảnh biến thể vào bảng images
                    if ($request->hasFile("variant_image.$key")) {
                        $image = $request->file("variant_image.$key");
                        $newName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $linkStorage = 'imageProducts/';
                        $image->move(public_path($linkStorage), $newName);
                        $imagePath = $linkStorage . $newName;
        
                        Image::create([
                            'product_variant_id' => $variantProduct->id,
                            'image_path' => $imagePath,
                        ]);
                    }
                }
            }
        }  

        return redirect()->route('admin.products.listProduct')->with('success', 'Cập nhật sản phẩm thành công');
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
        // Trả về view chi tiết sản phẩm
        return view('products.detail-product', compact('product', 'totalReviews', 'averageRating'));
    }


    public function showReviews($id){
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->where('is_visible', true)->get(); // Chỉ lấy đánh giá hiển thị
        return view('products.detail-product', compact('product', 'reviews'));
    }

}
