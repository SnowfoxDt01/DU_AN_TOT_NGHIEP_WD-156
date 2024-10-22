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
}
