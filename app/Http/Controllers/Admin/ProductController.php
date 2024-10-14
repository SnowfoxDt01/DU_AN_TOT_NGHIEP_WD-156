<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function listProduct(Request $request){
        $query = Product::with('category');

        // lọc theo tên
        if($request->filled('name')){
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        } elseif ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        } elseif ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
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

    public function addProduct(){
        $categories = \App\Models\Category::all();
        return view('products.add-product', compact('categories'));
    }

    public function addPostProduct(Request $req){ 
        $linkImage = '';
        if($req->hasFile('imageSP')){
            $image = $req->file('imageSP');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);

            $linkImage = $linkStorage . $newName;
        }     
        $data = [
            'name' => $req->nameSP,
            'description' => $req->descriptionSP,
            'price' => $req->priceSP,
            'image' => $linkImage,
            'quantity' => $req->quantitySP,
            'product_category_id' => $req->product_category_idSP
        ];
        Product::create($data);
        return redirect()->route('admin.products.listProduct');
    }
    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.listProduct');
    }

    public function hardDeleteProduct($id){
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete(); // Xóa cứng sản phẩm
        return redirect()->route('admin.products.listProduct');
    }
    public function editProduct($id){
        $product = Product::findOrFail($id);
        return view('products.edit-product')->with('product', $product);
    }
    
    public function updateProduct(Request $req, $id){
        $product = Product::findOrFail($id);
    
        $linkImage = $product->image;
        if($req->hasFile('imageSP')){
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
            'price' => $req->priceSP,
            'image' => $linkImage,
            'quantity' => $req->quantitySP,
            'product_category_id' => $req->product_category_idSP
        ];
        
        $product->update($data);
    
        return redirect()->route('admin.products.listProduct');
    }
    

    public function detailProduct($id) {
        // Lấy thông tin sản phẩm dựa trên ID
        $product = Product::with('category')->findOrFail($id);
        
        // Trả về view chi tiết sản phẩm
        return view('products.detail-product')->with('product', $product);
    }
    
}
