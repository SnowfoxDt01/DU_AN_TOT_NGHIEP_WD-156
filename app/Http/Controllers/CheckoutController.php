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
}
