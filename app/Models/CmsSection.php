<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CmsSection extends Model
{
    protected $fillable = [
        'page_id',
        'section_type',
        'order',
        'settings_json',
    ];

    protected $casts = [
        'settings_json' => 'json',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class, 'page_id');
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(CmsBlock::class, 'section_id')->orderBy('order', 'asc');
    }
}
