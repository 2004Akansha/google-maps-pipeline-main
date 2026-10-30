<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'business_id',
        'external_review_id',
        'author',
        'rating',
        'review_date',
        'review_text',
        'owner_response',
        'source_url',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'review_date' => 'date',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}