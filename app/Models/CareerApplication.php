<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'career_job_id',
        'name',
        'email',
        'phone',
        'cv_original_name',
        'cv_storage_path',
        'cv_mime_type',
        'cv_size',
        'status',
        'internal_notes',
        'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'cv_size' => 'integer',
            'applied_at' => 'datetime',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($app) {
            if (empty($app->reference)) {
                $app->reference = static::generateUniqueReference();
            }
            if (empty($app->applied_at)) {
                $app->applied_at = now();
            }
        });
    }

    public static function generateUniqueReference(): string
    {
        $year = date('Y');
        $last = static::withTrashed()->whereYear('created_at', $year)->latest('id')->first();
        $nextNumber = $last ? ($last->id + 1) : 1;
        $reference = sprintf('APP-%s-%06d', $year, $nextNumber);

        while (static::withTrashed()->where('reference', $reference)->exists()) {
            $nextNumber++;
            $reference = sprintf('APP-%s-%06d', $year, $nextNumber);
        }

        return $reference;
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(CareerJob::class, 'career_job_id')->withTrashed();
    }

    public function answers(): HasMany
    {
        return $this->hasMany(CareerApplicationAnswer::class, 'career_application_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(CareerApplicationStatusLog::class, 'career_application_id')->orderBy('created_at', 'desc');
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(CareerEmailLog::class, 'career_application_id')->orderBy('created_at', 'desc');
    }

    // Accessors & Helpers
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending Review',
            'under_review' => 'Under Review',
            'shortlisted' => 'Shortlisted',
            'interview_scheduled' => 'Interview Scheduled',
            'interviewed' => 'Interviewed',
            'selected' => 'Selected',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            'hired' => 'Hired',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'under_review' => 'bg-blue-50 text-blue-700 border-blue-200',
            'shortlisted' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'interview_scheduled' => 'bg-purple-50 text-purple-700 border-purple-200',
            'interviewed' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            'selected' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'hired' => 'bg-green-100 text-green-800 border-green-300 font-bold',
            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
            'withdrawn' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    public function getFormattedCvSizeAttribute(): string
    {
        $bytes = $this->cv_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function getIsPreviewableAttribute(): bool
    {
        $mime = strtolower($this->cv_mime_type ?? '');
        $ext = strtolower(pathinfo($this->cv_original_name ?? '', PATHINFO_EXTENSION));

        return in_array($ext, ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'gif']) ||
               str_contains($mime, 'pdf') ||
               str_starts_with($mime, 'image/');
    }

    public function getIsPdfAttribute(): bool
    {
        $mime = strtolower($this->cv_mime_type ?? '');
        $ext = strtolower(pathinfo($this->cv_original_name ?? '', PATHINFO_EXTENSION));
        return $ext === 'pdf' || str_contains($mime, 'pdf');
    }

    public function getIsImageAttribute(): bool
    {
        $mime = strtolower($this->cv_mime_type ?? '');
        $ext = strtolower(pathinfo($this->cv_original_name ?? '', PATHINFO_EXTENSION));
        return in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif']) || str_starts_with($mime, 'image/');
    }
}
