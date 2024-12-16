<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\CustomerRequest;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Customer;
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

        $customer = $user->customer ?? null;

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
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('client.account.myaccount', compact('user', 'orders', 'confirmOrders', 'confirmedOrders', 'shippingOrders', 'completedOrders', 'canceledOrders', 'customer'));
    }


    public function cancelOrder(Request $request, ShopOrder $order)
    {
        // Kiểm tra quyền truy cập  
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        $validStatuses = ['confirming', 'confirmed'];
        if (!in_array($order->order_status, $validStatuses)) {
            return redirect()->back()->with('error', 'Trạng thái đơn hàng không hợp lệ.');
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

        $originalTotalPrice = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        if ($order->voucherUser && $order->voucherUser->voucher) {
            $voucher = $order->voucherUser->voucher;

            if ($voucher->discount_type === 'percentage') {
                $discountAmount = $originalTotalPrice * ($voucher->discount / 100);
            } elseif ($voucher->discount_type === 'fixed') {
                $discountAmount = $voucher->discount;
            }
            //Tiền không âm
            $discountAmount = min($discountAmount, $originalTotalPrice);
        }

        return view('client.orders.detail', compact('order', 'discountAmount'));
    }

    public function detailProduct(string $id)
    {
        $detailProduct = Product::with('variantProducts')->findOrFail($id);
        $sizes = Size::orderBy('name')->get();

        $totalReviews = $detailProduct->reviews->count();

        $averageRating = $totalReviews > 0 ? $detailProduct->reviews->avg('rating') : 0;

        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = ShopOrder::where('user_id', Auth::id())
                ->whereHas('items', function ($query) use ($id) {
                    $query->where('product_id', $id);
                })
                ->exists();
        }

        return view('client.detail-product', compact('detailProduct', 'totalReviews', 'sizes', 'averageRating', 'hasPurchased'));
    }

    public function shopProducts()
    {
        $products = Product::paginate(9);
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();
        return view('client.products.shop', compact('products', 'flash_sale_products'));
    }

    public function newProducts()
    {
        $newProducts = Product::where('new', 1)->paginate(8);
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();
        return view('client.products.new', compact('newProducts', 'flash_sale_products'));
    }


    public function topProducts()
    {
        // Lấy tất cả các sản phẩm, phân trang 9 sản phẩm một lần
        $products = Product::paginate(9);

        // Lấy danh sách các sản phẩm yêu thích (tính theo số lượng đã bán)
        $topProducts = ShopOrderItem::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(10)
            ->get();

        // Lấy các sản phẩm đang flash sale
        $flash_sale_products = Product::where('flash_sale_price', '<>', 0)->get();

        // Trả về view và truyền dữ liệu
        return view('client.products.top', compact('products', 'topProducts', 'flash_sale_products'));
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

    public function createInfo()
    {
        session(['active_tab' => 'warranty']);

        return redirect()->to('client/myaccount');
    }



    public function createCustomerInfo(CustomerRequest $request)
    {
        $user = auth()->user();
    
        DB::beginTransaction();
        try {
            $customer = Customer::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'id_user' => $user->id,
            ]);
    
            Address::create([
                'address' => $customer->address,
                'zip_code' => null,
                'recipient_name' => $customer->name,
                'recipient_phone' => $customer->phone,
                'customer_id' => $customer->id,
            ]);
    
            DB::commit(); // Commit transaction nếu mọi thứ thành công
            return redirect()->back()->with('success', "Cập nhật thành công.");
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction nếu có lỗi
            return redirect()->back()->with('error', "Đã xảy ra lỗi: " . $e->getMessage());
        }
    }

    public function updateCustomerInfo(CustomerRequest $request, string $id)
    {
        $user = auth()->user();
        $customer = $user->customer;

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address'=>$request->address,
            'id_user' => $user->id,
        ]);

        return redirect()->back()->with('success', "Cập nhật thành công.");
    }
}
