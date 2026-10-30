<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = [
        'business_id',
        'photo_url',
        'photo_key',
        'photo_type',
        'source_url',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}