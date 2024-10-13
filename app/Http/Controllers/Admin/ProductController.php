<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function listProduct(){
        $listProduct = Product::with('category')->paginate(5);
        return view('products.index')->with([
            'listProduct' => $listProduct
        ]);
    }

    public function addProduct(){
        return view('products.add-product');
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
    

    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $product->delete(); 
        return redirect()->route('admin.products.listProduct');
    }
}
