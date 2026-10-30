<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExtractionJob;

class ExtractionJobApiController extends Controller
{
    public function show(ExtractionJob $extractionJob)
    {
        $extractionJob->load('source');

        return response()->json([
            'success' => true,

            'data' => [
                'id' => $extractionJob->id,

                'source_id' =>
                    $extractionJob->source_id,

                'source_name' =>
                    $extractionJob->source?->name,

                'search_query' =>
                    $extractionJob->search_query,

                'collect_business_details' =>
                    (bool) $extractionJob->collect_business_details,

                'collect_reviews' =>
                    (bool) $extractionJob->collect_reviews,

                'collect_photos' =>
                    (bool) $extractionJob->collect_photos,

                'status' =>
                    $extractionJob->status,

                'total_businesses' =>
                    $extractionJob->total_businesses,

                'processed_businesses' =>
                    $extractionJob->processed_businesses,

                'successful_businesses' =>
                    $extractionJob->successful_businesses,

                'failed_businesses' =>
                    $extractionJob->failed_businesses,
            ]
        ]);
    }
}