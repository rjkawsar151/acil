<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CareerJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'department_id',
        'department_name',
        'location',
        'workplace_type',
        'employment_type',
        'vacancies',
        'salary_type',
        'salary_min',
        'salary_max',
        'currency',
        'cover_image',
        'show_salary',
        'short_description',
        'description',
        'responsibilities',
        'education_requirements',
        'experience_requirements',
        'additional_requirements',
        'benefits',
        'application_deadline',
        'status',
        'allow_applications',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'vacancies' => 'integer',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'show_salary' => 'boolean',
            'allow_applications' => 'boolean',
            'application_deadline' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = static::generateUniqueSlug($job->title);
            }
            if ($job->status === 'published' && empty($job->published_at)) {
                $job->published_at = now();
            }
        });

        static::updating(function ($job) {
            if ($job->isDirty('title') && empty($job->slug)) {
                $job->slug = static::generateUniqueSlug($job->title, $job->id);
            }
            if ($job->isDirty('status') && $job->status === 'published' && empty($job->published_at)) {
                $job->published_at = now();
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }

    // Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(CareerDepartment::class, 'department_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(CareerJobQuestion::class, 'career_job_id')->orderBy('sort_order', 'asc');
    }

    public function activeQuestions(): HasMany
    {
        return $this->questions()->where('is_active', true)->orderBy('sort_order', 'asc');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class, 'career_job_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePublicActive($query)
    {
        return $query->where('status', 'published')
            ->where('allow_applications', true)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            });
    }

    // Helpers & Accessors
    public function getEffectiveDepartmentNameAttribute(): string
    {
        if ($this->department && $this->department->name) {
            return $this->department->name;
        }
        return $this->department_name ?: 'General';
    }

    public function getWorkplaceTypeLabelAttribute(): string
    {
        return match ($this->workplace_type) {
            'on_site' => 'On-site',
            'remote' => 'Remote',
            'hybrid' => 'Hybrid',
            default => ucfirst(str_replace('_', ' ', $this->workplace_type ?: 'On-site')),
        };
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        return match ($this->employment_type) {
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contractual' => 'Contractual',
            'internship' => 'Internship',
            default => ucfirst(str_replace('_', ' ', $this->employment_type ?: 'Full Time')),
        };
    }

    public function getFormattedSalaryAttribute(): string
    {
        if (!$this->show_salary || $this->salary_type === 'hidden') {
            return 'Negotiable';
        }

        $currency = $this->currency ?: 'BDT';

        if ($this->salary_type === 'negotiable') {
            return 'Negotiable';
        }

        if ($this->salary_type === 'fixed' && $this->salary_min) {
            return $currency . ' ' . number_format($this->salary_min);
        }

        if ($this->salary_type === 'range') {
            if ($this->salary_min && $this->salary_max) {
                return $currency . ' ' . number_format($this->salary_min) . ' – ' . number_format($this->salary_max);
            } elseif ($this->salary_min) {
                return 'From ' . $currency . ' ' . number_format($this->salary_min);
            } elseif ($this->salary_max) {
                return 'Up to ' . $currency . ' ' . number_format($this->salary_max);
            }
        }

        return 'Negotiable';
    }

    public function getIsDeadlinePassedAttribute(): bool
    {
        if (!$this->application_deadline) {
            return false;
        }
        return $this->application_deadline->isPast() && !$this->application_deadline->isToday();
    }

    public function getIsAcceptingApplicationsAttribute(): bool
    {
        return $this->status === 'published' && $this->allow_applications && !$this->is_deadline_passed;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'published' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'draft' => 'bg-amber-100 text-amber-800 border-amber-200',
            'closed' => 'bg-rose-100 text-rose-800 border-rose-200',
            'archived' => 'bg-slate-100 text-slate-700 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (!empty($this->cover_image)) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }
            if (file_exists(public_path('storage/' . $this->cover_image))) {
                return asset('storage/' . $this->cover_image);
            }
            return asset('storage/' . $this->cover_image);
        }

        // High quality curated 16:9 industrial, laboratory, chemistry & plant covers
        $slug = Str::slug(($this->department?->slug ?? '') . ' ' . $this->title);
        
        if (str_contains($slug, 'chemist') || str_contains($slug, 'research') || str_contains($slug, 'r-d') || str_contains($slug, 'formulation')) {
            return 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&h=675&q=80';
        }
        
        if (str_contains($slug, 'quality') || str_contains($slug, 'qa') || str_contains($slug, 'qc') || str_contains($slug, 'microbiol')) {
            return 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=1200&h=675&q=80';
        }

        if (str_contains($slug, 'process') || str_contains($slug, 'plant') || str_contains($slug, 'engineer') || str_contains($slug, 'manufacturing')) {
            return 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&h=675&q=80';
        }

        if (str_contains($slug, 'supply') || str_contains($slug, 'procurement') || str_contains($slug, 'warehouse') || str_contains($slug, 'logistics')) {
            return 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&h=675&q=80';
        }

        if (str_contains($slug, 'commercial') || str_contains($slug, 'sales') || str_contains($slug, 'executive') || str_contains($slug, 'business')) {
            return 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&h=675&q=80';
        }

        return 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=1200&h=675&q=80';
    }
}
