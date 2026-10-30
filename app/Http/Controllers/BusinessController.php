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
            ->paginate(10)
            ->withQueryString();

        $sources = Source::orderBy('name')->get();

        return view('businesses.index', compact(
            'businesses',
            'sources'
        ));
    }


    public function show(Business $business)
{
    $business->load('source');

    $business->loadCount([
        'reviews',
        'photos',
    ]);

    return view('businesses.show', compact('business'));
}
}