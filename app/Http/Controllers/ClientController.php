<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use App\Models\Size;
use App\Models\Voucher;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
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
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();
        $blogs = Blog::limit(4)->get();
        return view('client.index', compact('categories', 'newProducts', 'topProducts', 'sale_products', 'flash_sale_products', 'banners', 'blogs'));
    }

    public function myAccount()
    {
        $user = Auth::user();
        $orders = ShopOrder::where('user_id', $user->id)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        $confirmOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CONFIRMING)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        $confirmedOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CONFIRMED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        $shippingOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::SHIPPING)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        $completedOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::COMPLETED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        $canceledOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CANCELED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->paginate(5);

        return view('client.account.myaccount', compact('user', 'orders', 'confirmOrders', 'confirmedOrders', 'shippingOrders', 'completedOrders', 'canceledOrders'));
    }
    
    public function cancelOrder($id)
    {
        $order = ShopOrder::findOrFail($id);

        // Kiểm tra quyền của người dùng
        if ($order->user_id != auth()->id()) {
            return redirect()->route('client.myaccount.myAccount')->with('error', 'Bạn không có quyền hủy đơn hàng này.');
        }

        if ($order->status == 'canceled') {
            return redirect()->route('client.myaccount.myAccount')->with('info', 'Đơn hàng này đã bị hủy trước đó.');
        }

        $order->order_status = 'canceled';
        $order->save();

        return redirect()->route('client.myaccount.myAccount');
    }


    public function detailProduct(string $id)
    {
        $detailProduct = Product::with('variantProducts')->findOrFail($id);
        $sizes = Size::orderBy('name')->get();

        $totalReviews = $detailProduct->reviews->count();

        $averageRating = $totalReviews > 0 ? $detailProduct->reviews->avg('rating') : 0;
        return view('client.detail-product', compact('detailProduct', 'totalReviews', 'sizes', 'averageRating'));
    }

    public function shopProducts()
    {
        $products = Product::paginate(9);
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();
        return view('client.products.shop', compact('products', 'flash_sale_products'));
    }

    public function productsOfCategory($id)
    {
        $category = Category::where('id', $id)->first();
        $productsOfCategory = Product::where('product_category_id', $id)->paginate(9);
        return view('client.categories.show', compact('productsOfCategory', 'category'));
    }

    public function blogList()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(9);
        return view('client.page.bloglist', compact('blogs'));
    }

    public function detailBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blogs = Blog::limit(4)->get();
        return view('client.page.blogDetail', compact('blog', 'blogs'));
    }

    public function voucherList()
    {
        $vouchers = Voucher::where(function ($query) {
            $query->whereNull('expiry_date')
                ->orWhere('expiry_date', '>=', Carbon::now());
        })
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereColumn('usage_count', '<', 'usage_limit');
            })
            ->where(function ($query) {
                $query->where('status', 'active');
            })
            ->paginate(9);

        return view('client.page.voucherList', compact('vouchers'));
    }
}
