<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index() {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(5);
        return view('blogs.index', compact('blogs'));
    }

    public function create() {
        return view('blogs.create');
    }

    public function store(BlogRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $fileName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('public/client_ui/assets/images/post'), $fileName);
                $imagePath = 'public/client_ui/assets/images/post/' . $fileName;
            }
        }

        Blog::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Tạo mới bài viết thành công.');
    }

    public function show($id){
        $blog = Blog::findOrFail($id);
        return view('blogs.show', compact('blog'));
    }

}
