<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer; 
        return view('checkout.profile.index', compact('customer')); 
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::user()->customer; 
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);


        $customer->update($request->only('name', 'phone', 'address'));

        return redirect()->route('client.checkout.index')->with([
            'success' => true,
            'customer' => $customer,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id', // Đảm bảo id_user hợp lệ
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'id_user' => $request->id_user,
        ]);

        return redirect()->route('client.checkout.index')->with('success', 'Khách hàng được thêm mới thành công.');
    }

}
