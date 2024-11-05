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

    // Định nghĩa các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'Transaction_id_user',
        'Transaction_id_merchant',
        'customer_id', // Thêm customer_id
        'user_id', // Thêm user_id
    ];

    // Mối quan hệ với ShoppingCartItem
    public function items()
    {
        return $this->hasMany(ShoppingCartItem::class, 'shopping_cart_id');
    }

    // Mối quan hệ với Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}