<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUser extends Model
{
    use HasFactory;
    protected $table = 'voucher_user';

    protected $fillable = [
        'voucher_id',
        'user_id',
        'order_id',
    ];
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
}
