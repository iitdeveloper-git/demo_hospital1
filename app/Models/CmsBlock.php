<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsBlock extends Model
{
    protected $fillable = [
        'section_id',
        'block_type',
        'content_json',
        'order',
    ];

    protected $casts = [
        'content_json' => 'json',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CmsSection::class, 'section_id');
    }
}
