<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'full_description',
        'icon',
        'featured_image',
        'banner_image',
        'department_id',
        'price_from',
        'duration',
        'benefits',
        'preparation',
        'procedure',
        'recovery_time',
        'faq',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'price_from' => 'decimal:2',
            'benefits' => 'array',
            'preparation' => 'array',
            'procedure' => 'array',
            'faq' => 'array',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
