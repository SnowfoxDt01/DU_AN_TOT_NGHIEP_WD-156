<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'id_user');
    }
<<<<<<< HEAD
=======
    
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
