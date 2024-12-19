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
            'discount' => 'required|numeric|max: 999999.99',
            'expiry_date' => 'nullable|date|after:today',
        ]);
        Voucher::create($request->all());
        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm mã giảm giá thành công.');
    }
        
    public function edit($id){
        $voucher = Voucher::findOrFail($id);
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        Voucher::where('id',$id)->update([
            'code'=> $request->code,
            'discount'=> $request->discount,
            'discount_type'=> $request->discount_type,
            'expiry_date'=> $request->expiry_date,
            'status'=> $request->status,
            'usage_limit'=> $request->usage_limit,
            'usage_count'=> $request->usage_count,
            'usage_count'=> $request->usage_count,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm mã giảm giá thành công.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return back();
    }

}
