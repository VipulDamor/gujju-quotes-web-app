<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'name',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'app_version',
        'platform',
        'os_version',
        'device_model',
        'device_manufacturer',
        'language',
        'country',
        'user_id',
        'is_logged_in',
        'status',
        'priority',
        'admin_response',
        'internal_notes',
        'responded_at',
        'responded_by',
        'ip_address',
        'user_agent',
        'api_version',
        'is_deleted',
        'deleted_at'
    ];

    protected $casts = [
        'is_logged_in' => 'boolean',
        'is_deleted' => 'boolean',
        'responded_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship with the admin who responded.
     */
    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Relationship with audit logs.
     */
    public function logs()
    {
        return $this->hasMany(ContactRequestLog::class);
    }

    /**
     * Scope to exclude deleted items by default.
     */
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
}
