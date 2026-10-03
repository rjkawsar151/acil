<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'caption',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
