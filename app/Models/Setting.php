<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return ($setting && !empty($setting->value)) ? $setting->value : $default;
        });
    }

    public static function getUrl(string $key, string $fallbackAsset = ''): string
    {
        $val = static::get($key);
        if (!empty($val)) {
            if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
                return $val;
            }
            return asset('storage/' . ltrim($val, '/'));
        }
        return !empty($fallbackAsset) ? asset($fallbackAsset) : '';
    }

    public static function set(string $key, $value, $group = 'general', $type = 'text', $label = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
            ]
        );
        Cache::forget("setting_{$key}");
    }
}
