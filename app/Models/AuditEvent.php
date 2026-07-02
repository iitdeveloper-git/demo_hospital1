<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'user_id',
        'action',
        'affected_module',
        'ip_address',
        'browser',
        'old_values_json',
        'new_values_json',
        'created_at',
    ];

    protected $casts = [
        'old_values_json' => 'json',
        'new_values_json' => 'json',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
