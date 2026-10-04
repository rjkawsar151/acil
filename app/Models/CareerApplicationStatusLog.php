<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationStatusLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'career_application_id',
        'old_status',
        'new_status',
        'changed_by',
        'notes',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class, 'career_application_id');
    }

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getOldStatusLabelAttribute(): string
    {
        if (!$this->old_status) {
            return '—';
        }
        return ucwords(str_replace('_', ' ', $this->old_status));
    }

    public function getNewStatusLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->new_status));
    }
}
