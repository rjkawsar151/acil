<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturingSection extends Model
{
    protected $fillable = [
        'step_number',
        'title',
        'subtitle',
        'description',
        'details',
        'icon',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'details' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'step_number' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('step_number', 'asc')->orderBy('sort_order', 'asc');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80';
    }
}
