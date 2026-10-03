<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_key',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'schema_markup',
    ];

    public static function getForPage(string $pageKey): ?self
    {
        return Cache::rememberForever("seo_page_{$pageKey}", function () use ($pageKey) {
            return static::where('page_key', $pageKey)->first();
        });
    }
}
