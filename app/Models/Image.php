<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'product_id',
        'product_variant_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantProduct()
    {
        return $this->belongsTo(VariantProduct::class);
    }
}
