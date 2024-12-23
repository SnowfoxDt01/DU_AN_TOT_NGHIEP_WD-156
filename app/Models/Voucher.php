<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'expiry_date',
        'status',
        'usage_limit',
        'usage_count',
    ];
    public function voucherUsers()
    {
        return $this->hasMany(VoucherUser::class, 'voucher_id');
    }
}
