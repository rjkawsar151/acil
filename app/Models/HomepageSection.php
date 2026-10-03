<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'badge_text',
        'content',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'image',
        'extra_data',
        'is_enabled',
        'sort_order',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true)->orderBy('sort_order', 'asc');
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return null;
    }
}
