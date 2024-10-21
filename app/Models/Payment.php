<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    public $primaryKey = 'id';
    public $fillable = [
        'user_id',
        'order_id',
    ];
    protected $dates = ['date_payment'];


    public function order(){
        return $this->belongsTo(ShopOrder::class, 'order_id');
    }
    
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
