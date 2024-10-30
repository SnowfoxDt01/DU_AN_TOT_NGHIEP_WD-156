<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShopOrderItem;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        $banners = Banner::where('status', Banner::STATUS_ACTIVE)->get();
        $newProducts = Product::where('new',1)->take(10)->get();
        $topProducts = ShopOrderItem::with('product')
        ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
        ->groupBy('product_id')
        ->orderByDesc('total_sales')
        ->take(10)
        ->get();
        $sale_products = Product::where('sale_price','<>',0)->get();
        return view('client.index', compact('categories','newProducts','topProducts','sale_products', 'banners'));
    }
    public function detailProduct(string $id){
        $categories = Category::all();
        $detailProduct = Product::with('variantProducts')->findOrFail($id);
        // dd($detailProduct);
        $totalReviews = $detailProduct->reviews->count();

        $averageRating = $totalReviews > 0 ? $detailProduct->reviews->avg('rating') : 0;
        return view('client.detail-product', compact('categories', 'detailProduct','totalReviews','averageRating'));
    }

}
