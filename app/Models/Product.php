<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    public $primaryKey = 'id';
    public $fillable = [
        'name',
        'description',
        'base_price',
        'flash_sale_price',
        'sale_price',
        'new',
        'product_category_id',
        'views'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
    // Relationship with ShopOrderItems (Many to Many through ShopOrderItems)
    public function shopOrderItems()
    {
        return $this->hasMany(ShopOrderItem::class);
    }
    // Relationship with ShopOrders (Many to Many through ShopOrderItems)
    public function orders()
    {
        return $this->belongsToMany(ShopOrder::class, 'shop_order_items', 'product_id', 'order_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function variantProducts()
    {
        return $this->hasMany(VariantProduct::class, 'product_id');
    }

    public function getTotalQuantity()
    {
        return $this->variantProducts->sum('quantity');
    }
}
