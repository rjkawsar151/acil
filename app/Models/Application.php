<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Application extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_description',
        'description',
        'features',
        'icon',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($app) {
            if (empty($app->slug)) {
                $app->slug = Str::slug($app->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80';
    }
}
