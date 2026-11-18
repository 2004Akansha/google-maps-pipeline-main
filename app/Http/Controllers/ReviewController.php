<?php

namespace App\Http\Controllers;

use App\Models\Business;

class ReviewController extends Controller
{
    public function index(Business $business)
    {
        $reviews = $business->reviews()
            ->latest('review_date')
            ->get();

        return view('reviews.index', compact(
            'business',
            'reviews'
        ));
    }
}