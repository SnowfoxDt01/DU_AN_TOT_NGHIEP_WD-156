<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class ShoppingCartController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        // Lấy giỏ hàng của người dùng hiện tại
        $user = Auth::user();
        $shoppingCart = $user->shoppingCart()->with('items.variantProduct.product.images', 'items.variantProduct.images')->first();

        return view('client.carts.index', compact('shoppingCart', 'categories'));
    }

    // ShoppingCartController.php

    public function add(Request $request)
    {
        // 1. Lấy thông tin từ request
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity');
        $userId = Auth::id(); // Lấy user_id của người dùng hiện tại

        // 2. Kiểm tra biến thể sản phẩm
        $variantProduct = VariantProduct::findOrFail($variantId);

        // 3. Lấy (hoặc tạo mới) giỏ hàng cho người dùng
        $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => $userId]);

        // 4. Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $existingItem = $shoppingCart->items()->where('variant_id', $variantId)->first();

        if ($existingItem) {
            // 4.1. Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity
            ]);
        } else {
            // 4.2. Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            ShoppingCartItem::create([
                'cart_id' => $shoppingCart->id,
                'variant_id' => $variantId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $variantProduct->price,
                
            ]);
        }

        // 5. Chuyển hướng về trang giỏ hàng 
        return redirect()->route('client.cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request, $itemId)
    {
        $cartItem = ShoppingCartItem::findOrFail($itemId);
        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $cartItem->price,
        ]);

        return redirect()->back()->with('success', 'Số lượng sản phẩm đã được cập nhật');
    }
    
}