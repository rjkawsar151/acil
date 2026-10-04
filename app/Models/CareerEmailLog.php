<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerEmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_application_id',
        'career_job_id',
        'email_type',
        'recipient_email',
        'cc',
        'bcc',
        'subject',
        'body',
        'status',
        'provider_message_id',
        'failure_reason',
        'sent_by',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'cc' => 'array',
            'bcc' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class, 'career_application_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(CareerJob::class, 'career_job_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->email_type) {
            'application_confirmation' => 'Confirmation Email',
            'interview_invitation' => 'Interview Invitation',
            'rejection' => 'Rejection Notice',
            'selected' => 'Selection Notice',
            default => ucwords(str_replace('_', ' ', $this->email_type)),
        };
    }
}
