<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'status',
        'id_user'
    ];

    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

}
