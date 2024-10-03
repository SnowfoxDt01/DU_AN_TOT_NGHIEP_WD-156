<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(){
        // danh sách sản phẩm
        $listProduct = [
            [
                'id' => '1',
                'name' => 'iphone15'
            ],
            [
                'id' => '2',
                'name' => 'iphone16'
            ]
            ];
        return view('list-product')->with([
            'listProduct' => $listProduct
        ]);
    }

    public function getProduct($id){
        echo $id;
    }

    public function updateProduct(Request $req){
        echo $req->id;
        echo $req->name;

    }
}
