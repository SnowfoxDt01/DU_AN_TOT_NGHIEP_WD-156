<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

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

}
