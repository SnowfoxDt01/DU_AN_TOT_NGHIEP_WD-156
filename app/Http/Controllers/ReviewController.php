<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function toggleVisibility($id){
        $review = Review::findOrFail($id);
        $review->is_visible = !$review->is_visible;
        $review->save();

        return back()->with('success', 'Trạng thái đánh giá đã được thay đổi.');
    }
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Lưu đánh giá vào cơ sở dữ liệu
        Review::create([
            'product_id' => $request->input('product_id'),
            'user_id' => $request->input('user_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'is_visible' => true,
        ]);
        
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được lưu!');
    }
}
