<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Source;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::with('source');

        /*
         * Search
         */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        /*
         * Filter by source
         */
        if ($request->filled('source_id')) {
            $query->where('source_id', $request->source_id);
        }

        $businesses = $query
            ->latest()
            ->get();

        $sources = Source::orderBy('name')->get();

        return view('businesses.index', compact(
            'businesses',
            'sources'
        ));
    }


   
public function show(Business $business)
{
    // Load business source
    $business->load('source');

    // Count all reviews and photos
    $business->loadCount([
        'reviews',
        'photos',
    ]);

    // Get latest 5 reviews
    $latestReviews = $business->reviews()
        ->latest('review_date')
        ->take(5)
        ->get();

    // Get latest 8 photos
    $latestPhotos = $business->photos()
        ->latest()
        ->take(8)
        ->get();

    return view('businesses.show', compact(
        'business',
        'latestReviews',
        'latestPhotos'
    ));
}

}