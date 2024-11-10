<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id_user'); // Liên kết với bảng customers
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
    
=======

>>>>>>> nhat
    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'user_id');
    }
>>>>>>> 0272c1157409a73f9f61dbdb114f12ad6a13f53b

    public function shoppingCart()
    {
        return $this->hasOne(ShoppingCart::class, 'user_id'); 
    }
}
