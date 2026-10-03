<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'brand',
        'short_description',
        'description',
        'benefits',
        'usage_information',
        'ingredients_information',
        'packaging_information',
        'available_sizes',
        'ph_level',
        'color_appearance',
        'featured_image',
        'brochure',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function inquiries()
    {
        return $this->hasMany(ProductInquiry::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'active');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('ingredients_information', 'like', "%{$search}%");
        });
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }
        return 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=80';
    }

    public function getBrochureUrlAttribute(): ?string
    {
        if ($this->brochure) {
            if (str_starts_with($this->brochure, 'http')) {
                return $this->brochure;
            }
            return asset('storage/' . $this->brochure);
        }
        return null;
    }
}
