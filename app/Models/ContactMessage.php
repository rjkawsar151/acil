<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'subject',
        'message',
        'ip_address',
        'is_read',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
