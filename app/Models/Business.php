<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = [
        'source_id',
        'name',
        'category',
        'address',
        'phone',
        'website',
        'rating',
        'review_count',
        'maps_url',
        'latitude',
        'longitude',
        'external_id',
        'status',
        'collected_at',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'collected_at' => 'datetime',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}