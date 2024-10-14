<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrderItem extends Model
{
    use HasFactory;
    protected $table = 'shop_order_items';

    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity',
         'price'
    ];


    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
