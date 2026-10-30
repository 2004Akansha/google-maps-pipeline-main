<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtractionJob extends Model
{
    protected $fillable = [
        'source_id',
        'search_query',

        'collect_business_details',
        'collect_reviews',
        'collect_full_reviews',
        'collect_photos',

        'status',

        'started_at',
        'completed_at',

        'total_businesses',
        'processed_businesses',
        'successful_businesses',
        'failed_businesses',

        'error_message',
    ];

    protected $casts = [
        'collect_business_details' => 'boolean',
        'collect_reviews' => 'boolean',
        'collect_photos' => 'boolean',
        'collect_full_reviews' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}