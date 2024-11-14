<?php

// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $shoppingCart = auth()->user()->shoppingCart;

        $customer = Auth::user()->customer->first();

        if (!$shoppingCart) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
        }

        return view('checkout.index', compact('shoppingCart', 'customer'));
    }
    public function applyVoucher(Request $request)
    {
        // Kiểm tra tồn tại hoặc hết hạn
        $voucher = Voucher::where('code', $request->code)
            ->where('expiry_date', '>=', now())
            ->where('status', 'active')
            ->first();

        if (!$voucher) {
            return response()->json(['error' => 'Mã giảm giá không tồn tại hoặc đã hết hạn!'], 400);
        }

        //Lấy giá trị tổng và giá trị tổng sau khi áp dụng mã
        $totalAmount = $request->total_amount;
        $finalAmount = $totalAmount;
        $discountType = $voucher->discount_type;

        if ($discountType === 'percentage') {
            // Lấy số phần trăm được giảm
            $discountType = rtrim(rtrim(number_format($voucher->discount, 2), '0'), '.' );
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
            'success' => 'Voucher applied successfully',
            'final_amount' => $finalAmount,
            'discount_type' => $discountType,
        ]);
    }
}
