<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;

class ShoppingCartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem giỏ hàng.');
        }
    
        $user = Auth::user();
    
        // Lấy giỏ hàng của người dùng hiện tại
        $shoppingCart = $user->shoppingCart()->with('items.variantProduct.product.images', 'items.variantProduct.images')->first();
    
        // Nếu người dùng chưa có giỏ hàng, có thể tạo mới
        if (!$shoppingCart) {
            $shoppingCart = ShoppingCart::create(['user_id' => $user->id]);
        }
    
        // Tổng số lượng sản phẩm trong giỏ hàng
        $cartQuantity = $shoppingCart->items->sum('quantity');
    
        return view('client.carts.index', compact('shoppingCart', 'cartQuantity'));
    }
    

    // ShoppingCartController.php

    public function add(Request $request)
    {
        // 1. Lấy thông tin từ request
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity');
        $userId = Auth::id(); // Lấy user_id của người dùng hiện tại

        if(Auth::check()){
            $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => $userId]);
        }
        else{
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!');

        }
        // 2. Kiểm tra biến thể sản phẩm
        $product = Product::findOrFail($productId);

        $variantProduct = VariantProduct::findOrFail($variantId);

        // 3. Lấy (hoặc tạo mới) giỏ hàng cho người dùng
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
                'price' => $product->flash_sale_price ?? $product->sale_price ?? $product->base_price,
            ]);
        }

        // 5. Chuyển hướng về trang giỏ hàng 
        return redirect()->route('client.cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request, $itemId)
    {
        $cartItem = ShoppingCartItem::findOrFail($itemId);
        $quantity = $request->quantity ?? 1;
        $maxQuantity = $cartItem->variantProduct->quantity;

        if ($quantity > $maxQuantity) {
            return response()->json([
                'error' => 'Số lượng vượt quá số lượng tồn kho!',
                'maxQuantity' => $maxQuantity,
            ], 400);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        // Tính tổng giá cho sản phẩm này
        $productPrice = $cartItem->product->sale_price > 0 ? $cartItem->product->sale_price : $cartItem->product->base_price;
        $lineTotal = number_format($productPrice * $quantity, 0, ',', '.');

        // Tính tổng giá của toàn bộ giỏ hàng
        $cartTotal = ShoppingCartItem::where('cart_id', $cartItem->cart_id)
            ->get()
            ->sum(function ($item) {
                $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->base_price;
                return $price * $item->quantity;
            });
        $cartTotalFormatted = number_format($cartTotal, 0, ',', '.');

        return response()->json([
            'success' => true,
            'message' => 'Số lượng sản phẩm đã được cập nhật',
            'lineTotal' => $lineTotal,
            'cartTotal' => $cartTotalFormatted,
        ]);
    }

    public function remove($itemId)
    {
        $cartItem = ShoppingCartItem::findOrFail($itemId);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}
