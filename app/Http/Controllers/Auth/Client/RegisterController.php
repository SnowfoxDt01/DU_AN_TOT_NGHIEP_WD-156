<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.client.register');
    }
    public function register(AuthRequest $request){
        try {
           $user = User::create($request->all());
            $user->assignRole('customer');
        }catch(\Throwable $th){
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
        return redirect()->route('login')->with('success', 'Đăng ký thành công.');
        
    }
}
