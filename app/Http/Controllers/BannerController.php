<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\File;


class BannerController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả các banner
        $banners = Banner::paginate(5);
        return view('banners.index', compact('banners'));
    }

    public function create()
    {
        // Trả về view tạo mới banner
        return view('banners.create');
    }

    public function store(Request $request)
    {
        $linkImage = '';
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            list($width, $height) = getimagesize($image);

            // Nếu kích thước không phải 1920x1080 thì trả về lỗi
            if ($width != 1920 || $height != 1080) {
                return back()->withErrors(['image_url' => 'Hình ảnh phải có kích thước 1920x1080px.']);
            }
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);
            $linkImage = $linkStorage . $newName;
        }
        $data = ([
            'title' => $request->title,
            'image_url' => $linkImage,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Lưu banner mới
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Tạo banner thành công');
    }

    public function show(Banner $banner)
    {
        // Hiển thị chi tiết một banner
        return view('banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        // Trả về view chỉnh sửa banner
        return view('banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $linkImage = $banner->image_url;
        if ($request->hasFile('image_url')) {
            File::delete(public_path($banner->image_url));
            $image = $request->file('image_url');
            list($width, $height) = getimagesize($image);

            // Nếu kích thước không phải 1920x1080 thì trả về lỗi
            if ($width != 1920 || $height != 1080) {
                return back()->withErrors(['image_url' => 'Hình ảnh phải có kích thước 1920x1080px.']);
            }
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $linkStorage = 'imageProducts/';
            $image->move(public_path($linkStorage), $newName);
            $linkImage = $linkStorage . $newName;
        }
        $data = ([
            'title' => $request->title,
            'image_url' => $linkImage,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Sửa banner thành công.');
    }

    public function destroy(Banner $banner)
    {
        // Xóa banner
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Xóa banner thành công.');
    }
}
