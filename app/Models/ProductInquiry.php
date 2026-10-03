<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInquiry extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'name',
        'company',
        'phone',
        'email',
        'quantity_requirement',
        'message',
        'ip_address',
        'is_read',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
