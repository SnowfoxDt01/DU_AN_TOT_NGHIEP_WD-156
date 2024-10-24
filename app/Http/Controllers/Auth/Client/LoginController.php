<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.client.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($user, $request->remember)) {
            return redirect()->route('client.index')->with('success', 'Đăng nhập thành công.');
        }
        return redirect()->back()->with('error', 'Sai thông tin đăng nhập!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('client.index')->with('success', 'Đăng xuất thành công.');
    }
}
