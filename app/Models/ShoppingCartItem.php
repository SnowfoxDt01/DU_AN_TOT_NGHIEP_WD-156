<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $table = 'shopping_cart_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cart_id',
        'variant_id',
        'product_id',
        'quantity',
        'price',
        'deleted_at'
    ];

    // Mối quan hệ với ShoppingCart
    public function shoppingCart()
    {
        return $this->belongsTo(ShoppingCart::class, 'cart_id');
    }

    // Mối quan hệ với VariantProduct
    public function variantProduct()
    {
        return $this->belongsTo(VariantProduct::class, 'variant_id');
    }

    // Mối quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}