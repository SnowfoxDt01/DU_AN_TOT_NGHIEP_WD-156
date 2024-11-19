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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            ->get();

        $confirmOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CONFIRMING)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->get();

        $confirmedOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CONFIRMED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->get();

        $shippingOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::SHIPPING)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->get();

        $completedOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::COMPLETED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->get();

        $canceledOrders = ShopOrder::where('user_id', $user->id)
            ->where('order_status', OrderStatus::CANCELED)
            ->with('items.product.images')
            ->orderBy('date_order', 'desc')
            ->get();

        return view('client.account.myaccount', compact('user', 'orders', 'confirmOrders', 'confirmedOrders', 'shippingOrders', 'completedOrders', 'canceledOrders'));
    }


    public function cancelOrder(Request $request, ShopOrder $order)
    {
        // Kiểm tra quyền truy cập  
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        // Xác thực lý do hủy  
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        // Cập nhật trạng thái đơn hàng và thêm lý do hủy  
        $order->order_status = 'canceled';
        $order->cancel_reason = $request->cancel_reason; // Đảm bảo có trường này trong bảng đơn hàng  
        $order->save();

        // Có thể thêm thông báo thành công nếu cần  
        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    public function orderDetail(string $id)
    {
        $order = ShopOrder::with(['items.product.images', 'user', 'voucherUser.voucher'])->find($id);

        $discountAmount = 0;

        if ($order->voucherUser && $order->voucherUser->voucher) {
            $voucher = $order->voucherUser->voucher;

            if ($voucher->discount_type === 'percentage') {
                $discountAmount = $order->total_price * ($voucher->discount / 100);
            } elseif ($voucher->discount_type === 'fixed') {
                $discountAmount = $voucher->discount;
            }
            //Tiền không âm
            $discountAmount = min($discountAmount, $order->total_price);
        }

        return view('client.orders.detail', compact('order', 'discountAmount'));
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
