<?php

// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Address;
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
    public function index(Request $request)
    {
        $this->handlePendingOrders();

        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $shoppingCart = auth()->user()->shoppingCart;

        if (!$shoppingCart) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
        }

        // Lấy các sản phẩm đã chọn từ request
        $selectedItems = $request->input('selected_items', []);

        // Kiểm tra nếu selectedItems không phải là mảng, chuyển nó thành mảng
        if (!is_array($selectedItems)) {
            $selectedItems = explode(',', $selectedItems); // Chuyển chuỗi thành mảng nếu nó là chuỗi
        }

        // Nếu không có sản phẩm nào được chọn
        if (empty($selectedItems)) {
            return redirect()->route('client.cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        // Lọc ra các sản phẩm đã chọn
        $selectedProducts = $shoppingCart->items->filter(function ($item) use ($selectedItems) {
            return in_array($item->id, $selectedItems);
        });

        // Nếu không có sản phẩm hợp lệ, thông báo lỗi
        if ($selectedProducts->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Không có sản phẩm hợp lệ.');
        }

        // Thông tin khách hàng và địa chỉ
        $customer = Auth::user()->customer;
        $addresses = $customer->addresses ?? collect();
        $defaultAddress = $addresses->first();

        $addressId = null;
        if ($defaultAddress) {
            $addressId = $defaultAddress->id;
        }

        // Truyền dữ liệu vào view
        return view('checkout.index', compact('shoppingCart', 'selectedProducts', 'customer', 'addresses', 'defaultAddress', 'addressId'));
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
            $voucherId = $voucher->id;

            // Lưu voucherId vào session
            session(['voucher_id' => $voucherId]);

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
                'voucherId' => $voucherId,
            ]);
        } else {
            return response()->json(['error' => 'Mã giảm giá không tồn tại hoặc đã hết hạn!'], 400);
        }
    }

    public function process(Request $request)
    {
        // dd(session()->getId());
        $paymentMethod = $request->input('payment_method');
        $addressId = $request->input('address_id');
        $address = Address::find($addressId);

        // Lấy thông tin giỏ hàng của người dùng
        $shoppingCart = auth()->user()->shoppingCart;

        // Lấy các sản phẩm đã chọn từ request
        $selectedProductIds = $request->input('selected_products', []);
        
        // Nếu không có sản phẩm nào được chọn, trả về lỗi
        if (empty($selectedProductIds)) {
            return redirect()->route('client.cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán!');
        }

        // Tính toán tổng tiền cho các sản phẩm đã chọn
        $cartTotal = $shoppingCart->items->filter(function ($item) use ($selectedProductIds) {
            return in_array($item->product->id, $selectedProductIds);
        })->sum(function ($item) {
            return ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price) * $item->quantity;
        });

        // Nếu giá trị final_amount từ client khác với tính toán từ server thì cập nhật lại
        $finalAmount = $request->input('final_amount', $cartTotal);
        if (is_null($finalAmount)) {
            $finalAmount = $cartTotal;
        }

        DB::beginTransaction();

        try {
            // Tạo đơn hàng mới
            $order = new ShopOrder();
            $order->user_id = Auth::id();
            $order->customer_id = auth()->user()->customer->id;
            $order->total_price = $finalAmount;
            $order->payment_method = $paymentMethod;
            $order->shipping_address = $address->address;
            $order->recipient_name = $address->recipient_name;
            $order->recipient_phone = $address->recipient_phone;
            $order->shipping_id = 1; // Bạn có thể thay đổi nếu cần
            $order->date_order = Carbon::now();
            $order->order_status = 'pending';
            $order->save();
            
            // Lưu voucher nếu có
            $voucherId = session('voucher_id');
            if ($voucherId) {
                $voucher_user = new VoucherUser();
                $voucher_user->user_id = Auth::id();
                $voucher_user->order_id = $order->id;
                $voucher_user->voucher_id = $voucherId;
                $voucher_user->save();
                session()->forget('voucher_id');
            }

            // Lưu chi tiết đơn hàng chỉ cho các sản phẩm đã chọn
            foreach ($shoppingCart->items as $item) {
                if (!in_array($item->variantProduct->id, $selectedProductIds)) {
                    continue; // Bỏ qua sản phẩm không được chọn
                }

                $itemPrice = ($item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price);
                $orderItem = new ShopOrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product->id;
                $orderItem->variant_id = $item->variantProduct->id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $itemPrice;
                $orderItem->save();

                // Giảm số lượng trong kho
                $variant = $item->variantProduct;
                if ($variant->quantity >= $item->quantity) {
                    $variant->decrement('quantity', $item->quantity);
                } else {
                    DB::rollBack();
                    return redirect()->route('client.cart.index')
                        ->with('error', "Sản phẩm '{$item->product->name}' không đủ hàng trong kho!");
                }
            }

            // Trong hàm process(), sau khi tạo đơn hàng $order  
            $cookie = cookie('selected_products', json_encode($selectedProductIds), 120);  
            return $this->redirectToVnpay($order)->withCookie($cookie);

            // Xóa giỏ hàng nếu thanh toán thành công
            // Xóa giỏ hàng chỉ sau khi tất cả đã hoàn tất
            if ($paymentMethod === 'cash') {
                // Xóa chỉ các sản phẩm đã chọn
                foreach ($shoppingCart->items as $item) {
                    if (in_array($item->variantProduct->id, $selectedProductIds)) {
                        $item->delete(); // Xóa sản phẩm đã chọn
                    }
                }
                $order->order_status = 'confirming';
                $order->save();
                session()->forget('voucher_id');
                DB::commit(); // Commit transaction
                return redirect()->route('client.cart.index')
                    ->with('success', 'Đơn hàng của bạn đã được đặt thành công! Hãy thanh toán khi nhận hàng nhé !!!');
            }


            if ($paymentMethod === 'vnpay') {
                
                // session()->put('selected_products', $selectedProductIds);
                DB::commit(); // Commit transaction trước khi chuyển hướng đến VNPay
                return $this->redirectToVnpay($order); // Chuyển hướng đến VNPay
                
            }

            return redirect()->route('client.cart.index')->with('error', 'Phương thức thanh toán không hợp lệ!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('client.cart.index')->with('error', 'Đã xảy ra lỗi trong quá trình xử lý đơn hàng!');
        }
        
    }



    private function redirectToVnpay($order)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('client.vnpay.return');
        $vnp_TmnCode = "UO4PS5ZJ"; //Mã website tại VNPAY 
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function vnpayReturn(Request $request)
    {
        // dd(session()->getId());
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $orderId = $request->input('vnp_TxnRef');

        // Lấy danh sách sản phẩm từ cookie  
        $selectedProductIds = json_decode($request->cookie('selected_products'), true); 
       
        $shoppingCart = auth()->user()->shoppingCart;

        // Tìm đơn hàng dựa trên orderId  
        $order = ShopOrder::find($orderId);

        if (!$order) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ($vnp_ResponseCode === '00') { // Mã phản hồi thanh toán thành công  
            // Cập nhật trạng thái đơn hàng  
            $order->order_status = 'confirming'; // Trạng thái đơn hàng  
            $order->payment_status = 'paid'; // Trạng thái thanh toán  
            $order->save(); // Lưu vào cơ sở dữ liệu  

            // Xóa sản phẩm đã chọn khỏi giỏ hàng
            foreach ($shoppingCart->items as $item) {
                if (in_array($item->variantProduct->id, $selectedProductIds)) {
                    $item->delete(); // Xóa sản phẩm đã chọn
                }
            }

            session()->forget('voucher_id'); // Xóa mã voucher trong session
            $cookie = cookie('selected_products', null, -1); // Xóa cookie  
            DB::commit(); // Commit transaction
            return redirect()->route('client.cart.index')->with('success', 'Thanh toán VNPay thành công!')->withCookie($cookie);
        } else {

            session()->forget('voucher_id');

            foreach ($order->items as $orderItem) {
                $variantProduct = $orderItem->variantProducts; // Lấy variant sản phẩm
                $variantProduct->quantity += $orderItem->quantity; // Cộng lại số lượng
                $variantProduct->save(); // Lưu lại thay đổi
            }
            // Nếu thanh toán thất bại, xóa đơn hàng
            $order->delete(); // Xóa đơn hàng khỏi cơ sở dữ liệu 

            return redirect()->route('client.cart.index')
                ->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }
    public function handlePendingOrders()
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }

        $pendingOrder = ShopOrder::where('user_id', $user->id)
            ->where('order_status', 'pending')
            ->first();

        if ($pendingOrder) {
            foreach ($pendingOrder->items as $orderItem) {
                $variantProduct = $orderItem->variantProducts; // Lấy variant sản phẩm
                $variantProduct->quantity += $orderItem->quantity; // Cộng lại số lượng
                $variantProduct->save(); // Lưu lại thay đổi
            }

            $pendingOrder->delete(); // Hoặc cập nhật trạng thái là 'cancelled' nếu cần
        }
    }
}
