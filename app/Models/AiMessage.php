<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiMessage extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_role',
        'message_content',
        'file_path',
        'token_count',
        'latency_ms',
    ];

    protected $casts = [
        'token_count' => 'integer',
        'latency_ms' => 'integer',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(AiFeedback::class);
    }
}
