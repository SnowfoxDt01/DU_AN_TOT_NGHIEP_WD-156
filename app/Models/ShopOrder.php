<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory;
    protected $table = 'shop_order';

    protected $fillable = [
        'date_order',
        'total_price',
        'order_status',
        'payment_status',
        'shipping_address',
        'payment_method',
        'shipped_at',
        'delivered_at',
        'user_id',
        'customer_id',
        'shipping_id ',
        'cancel_reason'


    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'payment_method'=>PaymentMethod::class,
        'date_order' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shop_order_items', 'order_id', 'product_id');
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function voucherUser()
    {
        return $this->hasOne(VoucherUser::class, 'order_id');
    }
}
