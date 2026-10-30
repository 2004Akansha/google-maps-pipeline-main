<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    protected $fillable = [
        'name',
        'website_url',
        'source_type',
        'status',
        'description',
    ];

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

     public function extractionJobs(): HasMany
    {
        return $this->hasMany(ExtractionJob::class);
    }
}