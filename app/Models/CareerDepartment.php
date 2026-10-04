<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CareerDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($dept) {
            if (empty($dept->slug)) {
                $dept->slug = Str::slug($dept->name);
            }
        });
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(CareerJob::class, 'department_id');
    }

    public function activeJobs(): HasMany
    {
        return $this->jobs()
            ->where('status', 'published')
            ->where('allow_applications', true)
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }
}
