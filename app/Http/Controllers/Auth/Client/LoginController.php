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
            $user = Auth::user();
            if ($user->hasRole(['super-admin', 'admin'])) {
                return redirect()->route('admin.products.listProduct')->with('success', 'Đăng nhập thành công.');
            }

            return redirect()->route('client.index')->with('success', 'Đăng nhập thành công.');
        }

        return redirect()->back() ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
        ->withInput($request->except('password'));
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('client.index')->with('success', 'Đăng xuất thành công.');
    }
}
