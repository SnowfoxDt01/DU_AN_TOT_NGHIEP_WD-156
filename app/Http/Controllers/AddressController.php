<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function setDefaultAddress($addressId)
    {
        // Đặt tất cả các địa chỉ của người dùng thành không mặc định
        Address::where('user_id', auth()->id())->update(['is_default' => false]);

        // Đặt địa chỉ mới làm mặc định
        $address = Address::find($addressId);
        $address->is_default = true;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được chọn làm mặc định.');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:10',
        ]);

        // Lưu địa chỉ vào cơ sở dữ liệu
        $address = new Address();
        $address->customer_id = Auth::user()->customer->id;
        $address->recipient_name = $request->recipient_name;
        $address->recipient_phone = $request->recipient_phone;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->ward = $request->ward;
        $address->address = $request->address;
        $address->zip_code = $request->zip_code;
        $address->save();

        return redirect()->back()->with('success', 'Địa chỉ đã được lưu!');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back();
    }
}
