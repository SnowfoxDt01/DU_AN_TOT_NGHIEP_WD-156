<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function listProduct(){
        $listProduct = Product::paginate(10);
        return view('products.index')->with([
            'listProduct' => $listProduct
        ]);
    }
}
