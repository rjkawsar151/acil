<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CareerJobQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_job_id',
        'question',
        'type',
        'options',
        'is_required',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(CareerJob::class, 'career_job_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(CareerApplicationAnswer::class, 'career_job_question_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'text' => 'Short Text',
            'textarea' => 'Long Text (Paragraph)',
            'number' => 'Number',
            'email' => 'Email',
            'phone' => 'Phone',
            'date' => 'Date',
            'yes_no' => 'Yes / No',
            'radio' => 'Single Choice (Radio)',
            'select' => 'Dropdown Menu',
            'checkbox' => 'Single Checkbox',
            'multi_checkbox' => 'Multiple Selection (Checkboxes)',
            default => ucfirst($this->type),
        };
    }
}
