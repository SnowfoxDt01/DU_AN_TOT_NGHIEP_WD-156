<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
