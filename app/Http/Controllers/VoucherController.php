<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::paginate(5);
        return view('vouchers.index', compact('vouchers'));
    }
    public function create()
    {
        return view('vouchers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers',
            'discount' => 'required|numeric',
            'expiry_date' => 'required|date|after:today',
        ]);
        Voucher::create($request->all());
        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm mã giảm giá thành công.');
    }
}
