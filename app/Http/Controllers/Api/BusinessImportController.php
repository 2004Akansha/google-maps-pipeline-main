<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ExtractionJob;
use App\Models\Photo;
use App\Models\Review;
use App\Models\Source;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BusinessImportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validate request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'job_id' => [
                'required',
                'integer',
                'exists:extraction_jobs,id',
            ],

            'source_id' => [
                'required',
                'integer',
                'exists:sources,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Business
            |--------------------------------------------------------------------------
            */

            'business' => [
                'required',
                'array',
            ],

            'business.name' => [
                'required',
                'string',
                'max:255',
            ],

            'business.category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'business.address' => [
                'nullable',
                'string',
            ],

            'business.phone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'business.website' => [
                'nullable',
                'string',
                'max:2048',
            ],

            'business.rating' => [
                'nullable',
                'numeric',
                'between:0,5',
            ],

            'business.review_count' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'business.maps_url' => [
                'required',
                'string',
                'max:2048',
            ],

            'business.latitude' => [
    'nullable',
    'numeric',
    'between:-90,90',
],

'business.longitude' => [
    'nullable',
    'numeric',
    'between:-180,180',
],

            'business.external_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Reviews
            |--------------------------------------------------------------------------
            */

            'reviews' => [
                'nullable',
                'array',
            ],

            'reviews.*.external_review_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reviews.*.author' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reviews.*.rating' => [
                'nullable',
                'numeric',
                'between:0,5',
            ],

            'reviews.*.review_date' => [
                'nullable',
                'date',
            ],

            'reviews.*.review_text' => [
                'nullable',
                'string',
            ],

            'reviews.*.owner_response' => [
                'nullable',
                'string',
            ],

            'reviews.*.source_url' => [
                'nullable',
                'string',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Photos
            |--------------------------------------------------------------------------
            */

            'photos' => [
                'nullable',
                'array',
            ],

            'photos.*.photo_key' => [
                'nullable',
                'string',
                'max:255',
            ],

            'photos.*.photo_url' => [
                'required',
                'string',
                'max:2048',
            ],

            'photos.*.photo_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'photos.*.source_url' => [
                'nullable',
                'string',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. Find Job and Source
        |--------------------------------------------------------------------------
        */

        $job = ExtractionJob::findOrFail(
            $validated['job_id']
        );

        $source = Source::findOrFail(
            $validated['source_id']
        );


        /*
        |--------------------------------------------------------------------------
        | 3. Make sure job belongs to source
        |--------------------------------------------------------------------------
        */

        if ($job->source_id !== $source->id) {

            return response()->json([
                'success' => false,
                'message' => 'The extraction job does not belong to this source.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | 4. Import everything inside transaction
        |--------------------------------------------------------------------------
        */

        try {

            $result = DB::transaction(function () use (
                $validated,
                $source
            ) {

                /*
                |--------------------------------------------------------------------------
                | Business
                |--------------------------------------------------------------------------
                */

                $businessData = $validated['business'];

                $business = null;


                /*
                 * First try external_id.
                 */

                if (!empty($businessData['external_id'])) {

                    $business = Business::where(
                        'source_id',
                        $source->id
                    )
                    ->where(
                        'external_id',
                        $businessData['external_id']
                    )
                    ->first();
                }


                /*
                 * If external_id didn't find anything,
                 * try maps_url.
                 */

                if (
                    !$business &&
                    !empty($businessData['maps_url'])
                ) {

                    $business = Business::where(
                        'source_id',
                        $source->id
                    )
                    ->where(
                        'maps_url',
                        $businessData['maps_url']
                    )
                    ->first();
                }


                /*
                 * Create new business if necessary.
                 */

                if (!$business) {

                    $business = new Business();

                    $business->source_id = $source->id;
                }


                /*
                 * Update business.
                 */

                $business->fill([

                    'name' =>
                        $businessData['name'],

                    'category' =>
                        $businessData['category'] ?? null,

                    'address' =>
                        $businessData['address'] ?? null,

                    'phone' =>
                        $businessData['phone'] ?? null,

                    'website' =>
                        $businessData['website'] ?? null,

                    'rating' =>
                        $businessData['rating'] ?? null,

                    'review_count' =>
                        $businessData['review_count'] ?? null,

                    'maps_url' =>
                        $businessData['maps_url'] ?? null,

                    'latitude' =>
                        $businessData['latitude'] ?? null,

                    'longitude' =>
                        $businessData['longitude'] ?? null,

                    'external_id' =>
                        $businessData['external_id'] ?? null,

                    'status' =>
                        'active',

                    'collected_at' =>
                        now(),
                ]);

                $business->save();


                /*
                |--------------------------------------------------------------------------
                | Reviews
                |--------------------------------------------------------------------------
                */

                $reviewsCreated = 0;
                $reviewsUpdated = 0;


                foreach (
                    $validated['reviews'] ?? []
                    as $reviewData
                ) {

                    $review = null;


                    if (
                        !empty(
                            $reviewData['external_review_id']
                        )
                    ) {

                        $review = Review::where(
                            'business_id',
                            $business->id
                        )
                        ->where(
                            'external_review_id',
                            $reviewData['external_review_id']
                        )
                        ->first();
                    }


                    if (!$review) {

                        $review = new Review();

                        $review->business_id =
                            $business->id;

                        $reviewsCreated++;

                    } else {

                        $reviewsUpdated++;
                    }


                    $review->fill([

                        'external_review_id' =>
                            $reviewData[
                                'external_review_id'
                            ] ?? null,

                        'author' =>
                            $reviewData['author'],

                        'rating' =>
                            $reviewData['rating'] ?? null,

                        'review_date' =>
                            $reviewData['review_date'] ?? null,

                        'review_text' =>
                            $reviewData['review_text'] ?? null,

                        'owner_response' =>
                            $reviewData['owner_response'] ?? null,

                        'source_url' =>
                            $reviewData['source_url']
                            ?? $business->maps_url,
                    ]);

                    $review->save();
                }


                /*
                |--------------------------------------------------------------------------
                | Photos
                |--------------------------------------------------------------------------
                */

                $photosCreated = 0;
                $photosUpdated = 0;


                foreach (
                    $validated['photos'] ?? []
                    as $photoData
                ) {

                    $photo = null;


                    /*
                     * First try photo_key.
                     */

                    if (
                        !empty(
                            $photoData['photo_key']
                        )
                    ) {

                        $photo = Photo::where(
                            'business_id',
                            $business->id
                        )
                        ->where(
                            'photo_key',
                            $photoData['photo_key']
                        )
                        ->first();
                    }


                    /*
                     * If photo_key did not find anything,
                     * try photo URL.
                     */

                    if (!$photo) {

                        $photo = Photo::where(
                            'business_id',
                            $business->id
                        )
                        ->where(
                            'photo_url',
                            $photoData['photo_url']
                        )
                        ->first();
                    }


                    if (!$photo) {

                        $photo = new Photo();

                        $photo->business_id =
                            $business->id;

                        $photosCreated++;

                    } else {

                        $photosUpdated++;
                    }


                    $photo->fill([
    'photo_url' => $photoData['photo_url'],

    'photo_key' => !empty($photoData['photo_key'])
    ? $photoData['photo_key']
    : hash('sha256', $photoData['photo_url']),

    'photo_type' => $photoData['photo_type'] ?? 'business',

    'source_url' => $photoData['source_url'] ?? $business->maps_url,
]);

                    $photo->save();
                }


                /*
                |--------------------------------------------------------------------------
                | Return transaction result
                |--------------------------------------------------------------------------
                */

                return [

                    'business' =>
                        $business,

                    'reviews_created' =>
                        $reviewsCreated,

                    'reviews_updated' =>
                        $reviewsUpdated,

                    'photos_created' =>
                        $photosCreated,

                    'photos_updated' =>
                        $photosUpdated,
                ];
            });


            /*
            |--------------------------------------------------------------------------
            | 5. Update job progress
            |--------------------------------------------------------------------------
            */

            $job->increment('processed_businesses');
            $job->increment('successful_businesses');


            /*
            |--------------------------------------------------------------------------
            | 6. Return response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'message' =>
                    'Business package imported successfully.',

                'data' => [

                    'job_id' =>
                        $job->id,

                    'business_id' =>
                        $result['business']->id,

                    'business_name' =>
                        $result['business']->name,

                    'reviews_created' =>
                        $result['reviews_created'],

                    'reviews_updated' =>
                        $result['reviews_updated'],

                    'photos_created' =>
                        $result['photos_created'],

                    'photos_updated' =>
                        $result['photos_updated'],

                    'job_progress' => [

                        'processed' =>
                            $job->processed_businesses,

                        'total' =>
                            $job->total_businesses,

                        'successful' =>
                            $job->successful_businesses,

                        'failed' =>
                            $job->failed_businesses,
                    ],
                ],

            ], 201);


        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Failed business
            |--------------------------------------------------------------------------
            */

            $job->increment('processed_businesses');
            $job->increment('failed_businesses');

            $job->update([
                'error_message' =>
                    $e->getMessage(),
            ]);


            return response()->json([

                'success' => false,

                'message' =>
                    'Business import failed.',

                'error' =>
                    $e->getMessage(),

            ], 500);
        }
    }
}