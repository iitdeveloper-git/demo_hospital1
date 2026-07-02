<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMetadata extends Model
{
    protected $table = 'seo_metadata';

    protected $fillable = [
        'model_type',
        'model_id',
        'meta_title',
        'meta_description',
        'og_image',
        'schema_json',
    ];

    protected $casts = [
        'schema_json' => 'json',
    ];
}
