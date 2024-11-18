<?php

// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopOrder;
use App\Models\ShopOrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $shoppingCart = auth()->user()->shoppingCart;

        $customer = Auth::user()->customer;

        if (!$shoppingCart) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
        }

        return view('checkout.index', compact('shoppingCart', 'customer'));
    }

    public function applyVoucher(Request $request)
    {
        // Kiểm tra tồn tại hoặc hết hạn
        $voucher = Voucher::where('code', $request->code)
            ->where(function ($query) {
                $query->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
            })
            ->where('status', 'active')
            ->first();

        if ($voucher) {
            // Kiểm tra xem người dùng đã sử dụng voucher chưa
            $userHasUsedVoucher = DB::table('voucher_user')
                ->where('voucher_id', $voucher->id)
                ->where('user_id', auth()->id()) // Kiểm tra người dùng hiện tại
                ->exists();

            if ($userHasUsedVoucher) {
                return response()->json(['error' => 'Bạn đã sử dụng mã này rồi.'], 400);
            }
            //Check số lượng sử dụng tối đa của mã
            if ($voucher->usage_limit !== null && $voucher->usage_count <= $voucher->usage_limit) {
                $voucher->increment('usage_count');
            }
            if ($voucher->usage_count > $voucher->usage_limit) {
                return response()->json(['error' => 'Mã giảm giá đã hết lượt sử dụng.'], 400);
            }
            //Khai báo số tiền tổng trước và sau khi áp mã và khai báo số phần atrawm được giảm
            $totalAmount = $request->total_amount;
            $finalAmount = $totalAmount;
            $discountType = $voucher->discount_type;

            if ($discountType === 'percentage') {
                // Lấy số phần trăm được giảm
                $discountType = rtrim(rtrim(number_format($voucher->discount, 2), '0'), '.');
                $discountType .= '%';
            } else {
                // Lấy số tiền cố định được giảm
                $discountType = number_format($voucher->discount, 0, ',', '.') . ' VND';
            }

            // Tính giảm giá dựa vào loại giảm giá của voucher
            if ($voucher->discount_type === 'fixed') {
                // Giảm giá theo giá cố định
                $finalAmount = max(0, $totalAmount - $voucher->discount); //0 để đảm bảo không âm
            } elseif ($voucher->discount_type === 'percentage') {
                // Giảm giá theo phần trăm
                $discountAmount = $totalAmount * ($voucher->discount / 100);
                $finalAmount = max(0, $totalAmount - $discountAmount);
            }
            // Trả về kết quả finalAmount là tổng giá sau khi áp dụng mã
            return response()->json([
                'success' => 'Áp dụng mã giảm giá thành công!!!',
                'final_amount' => $finalAmount,
                'discount_type' => $discountType,
            ]);
        } else {
            return response()->json(['error' => 'Mã giảm giá không tồn tại hoặc đã hết hạn!'], 400);
        }
    }

    public function process(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        // Lấy thông tin giỏ hàng
        $shoppingCart = auth()->user()->shoppingCart;
        // Tính tổng giá trị giỏ hàng
        $cartTotal = $shoppingCart->items->sum(function ($item) {
            $price = $item->product->sale_price > 0 
                ? $item->product->sale_price 
                : $item->product->base_price;
            return $price * $item->quantity;
        });
        // Tạo đơn hàng mới
        $order = new ShopOrder();
        $order->user_id = Auth::id();
        $order->customer_id = auth()->user()->customer->id;
        $order->total_price = $cartTotal; // Sử dụng $cartTotal đã tính ở trên
        $order->payment_method = $paymentMethod;
        $order->shipping_address = auth()->user()->customer->first()->address;
        $order->shipping_id = 1;
        $order->date_order = Carbon::now();
        $order->save();
        // Lưu chi tiết đơn hàng
        foreach ($shoppingCart->items as $item) {
            $orderItem = new ShopOrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->product->id; 
            // Lấy variant_id từ relationship variantProduct của item
            $orderItem->variant_id = $item->variantProduct->id; 
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->product->sale_price > 0 
                ? $item->product->sale_price 
                : $item->product->base_price;
            $orderItem->save();
        }
        // Xóa giỏ hàng
        $shoppingCart->items()->delete();
        // Chuyển hướng người dùng
        // dd($paymentMethod);
        if ($paymentMethod === 'vnpay') {
            // Chuyển hướng đến VNPay
            return $this->redirectToVnpay($order);
        } elseif ($paymentMethod === 'cash') {
            // Xử lý logic cho thanh toán tiền mặt (nếu có)
            return redirect()->route('client.cart.index')
                ->with('success', 'Đơn hàng của bạn đã được đặt thành công! Thanh toán khi nhận hàng.');
        }
    
        return redirect()->route('client.cart.index')->with('error', 'Phương thức thanh toán không hợp lệ!');
    }

    private function redirectToVnpay($order)
    {

    
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = route('client.vnpay.return');
    $vnp_TmnCode = "UO4PS5ZJ";//Mã website tại VNPAY 
    $vnp_HashSecret = "EN9VZ92UHTMVTWLFQ4SZM71EBFTBS3GP"; //Chuỗi bí mật
    
    $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = "Thanh toán đơn hàng #{$order->id}";
    $vnp_OrderType = "shop_ban_giay";
    $vnp_Amount = $order->total_price * 100;
    $vnp_Locale = "VN";
    $vnp_BankCode = "NCB";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }
    
    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    header('Location: ' . $vnp_Url);
    die();
        
    
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $orderId = $request->input('vnp_TxnRef');

        if ($vnp_ResponseCode === '00') {
            return redirect()->route('client.cart.index')
                ->with('message', 'Thanh toán thành công!');
        }

        return redirect()->route('client.cart.index')
            ->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
    }

}
