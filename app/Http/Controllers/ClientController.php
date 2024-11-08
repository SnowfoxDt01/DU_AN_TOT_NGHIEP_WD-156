<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShopOrderItem;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $banners = Banner::where('status', Banner::STATUS_ACTIVE)->get();
        $newProducts = Product::where('new', 1)->paginate(8);
        $topProducts = ShopOrderItem::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(10)
            ->get();
        $sale_products = Product::where('sale_price', '<>', 0)->get();
        return view('client.index', compact('categories', 'newProducts', 'topProducts', 'sale_products', 'banners'));
    }

    public function myAccount(){
        return view('client.account.myaccount');
    }

    public function detailProduct(string $id)
    {
        $detailProduct = Product::with('variantProducts')->findOrFail($id);
        $sizes = Size::orderBy('name')->get();

        $totalReviews = $detailProduct->reviews->count();

        $averageRating = $totalReviews > 0 ? $detailProduct->reviews->avg('rating') : 0;
        return view('client.detail-product', compact('detailProduct', 'totalReviews','sizes', 'averageRating'));
    }

    public function shopProducts() {
        $products = Product::paginate(9);
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();
        return view('client.products.shop', compact('products','flash_sale_products'));
    }

    public function productsOfCategory($id){
        $category = Category::where('id',$id)->first();
        $productsOfCategory = Product::where('product_category_id',$id)->paginate(9);
        return view('client.categories.show', compact('productsOfCategory','category'));
    }
}
