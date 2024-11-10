<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingCart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shopping_cart';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 
        'total_price',
        'deleted_at'
    ];

    // Mối quan hệ với Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');  // Liên kết với bảng customer
    }

    // Mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  
    }

    // Mối quan hệ với ShoppingCartItem
    public function items()
    {
        return $this->hasMany(ShoppingCartItem::class, 'cart_id');
    }
}
