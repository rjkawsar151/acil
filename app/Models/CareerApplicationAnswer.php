<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_application_id',
        'career_job_question_id',
        'question_snapshot',
        'question_type_snapshot',
        'answer_text',
        'answer_json',
    ];

    protected function casts(): array
    {
        return [
            'answer_json' => 'array',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class, 'career_application_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(CareerJobQuestion::class, 'career_job_question_id');
    }

    public function getFormattedAnswerAttribute(): string
    {
        if (!empty($this->answer_json) && is_array($this->answer_json)) {
            return implode(', ', $this->answer_json);
        }
        if ($this->question_type_snapshot === 'yes_no') {
            return in_array(strtolower((string)$this->answer_text), ['1', 'true', 'yes']) ? 'Yes' : 'No';
        }
        return $this->answer_text ?: '—';
    }
}
