<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'location',
        'target',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    public function activeChildren()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function scopeHeader($query)
    {
        return $query->where('location', 'header')->whereNull('parent_id')->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function scopeFooter($query)
    {
        return $query->where('location', 'footer')->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
