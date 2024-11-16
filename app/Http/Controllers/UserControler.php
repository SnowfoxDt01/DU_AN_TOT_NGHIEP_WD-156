<?php

namespace App\Http\Controllers;

use App\Models\ShopOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->input('keyword');
            $query->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('email', 'LIKE', "%{$keyword}%");
        }

        $status = $request->input('status');
        if ($status !== null) {
            $query->where('status', $status);
        }

        $users = $query->paginate(5);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create($request->all());

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $orders = ShopOrder::where('user_id', $id)
            ->with('items.product')
            ->orderBy('date_order', 'desc')
            ->paginate(10);

        return view('users.show', compact('user', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user= User::find($id);
        return view('users.update',compact('user'));
    }
     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        User::where('id',$id)->update(['status'=> $request->status]);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkChangePassWord(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', function ($attr, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Mật khẩu hiện tại không đúng! Vui lòng nhập lại.');
                }
            }],
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user->update(['password' => bcrypt($request->new_password)]);

        return redirect()->route('client.myaccount.myAccount')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}