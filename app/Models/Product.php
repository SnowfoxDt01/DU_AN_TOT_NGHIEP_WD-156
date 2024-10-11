<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    public $primaryKey = 'id';
    public $fillable = [
        'name',
        'description',
        'price',
        'image',
        'quantity',
        'product_category_id'
    ];
}
