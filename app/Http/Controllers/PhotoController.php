<?php

namespace App\Http\Controllers;

use App\Models\Business;

class PhotoController extends Controller
{
    public function index(Business $business)
    {
        $photos = $business->photos()
            ->latest()
            ->paginate(24);

        return view('photos.index', compact(
            'business',
            'photos'
        ));
    }
}