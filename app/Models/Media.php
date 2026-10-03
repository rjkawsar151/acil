<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'name',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'alt_text',
    ];

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }
        return asset('storage/' . $this->file_path);
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}
