<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'banner_image',
        'excerpt',
        'content',
        'template',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getBannerImageUrlAttribute(): string
    {
        if ($this->banner_image) {
            if (str_starts_with($this->banner_image, 'http')) {
                return $this->banner_image;
            }
            return asset('storage/' . $this->banner_image);
        }
        return 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80';
    }
}
