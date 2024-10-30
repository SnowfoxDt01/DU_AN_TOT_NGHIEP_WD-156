<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.client.login');
    }

    public function login(LoginRequest $request)
    {
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
