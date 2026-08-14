<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_request_id',
        'admin_id',
        'action',
        'old_value',
        'new_value',
        'ip_address'
    ];

    /**
     * Relationship with the contact request.
     */
    public function contactRequest()
    {
        return $this->belongsTo(ContactRequest::class);
    }

    /**
     * Relationship with the admin who performed the action.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
