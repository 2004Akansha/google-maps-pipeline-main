<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of sources.
     */
    public function index()
    {
        $sources = Source::latest()->get();

        return view('sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new source.
     */
    public function create()
    {
        return view('sources.create');
    }

    /**
     * Store a newly created source.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'source_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Source::create($validated);

        return redirect()
            ->route('sources.index')
            ->with('success', 'Source created successfully.');
    }

    /**
     * Display the specified source.
     */
    public function show(Source $source)
    {
        $source->loadCount('businesses');

        $reviewCount = $source->businesses()
            ->withCount('reviews')
            ->get()
            ->sum('reviews_count');

        $photoCount = $source->businesses()
            ->withCount('photos')
            ->get()
            ->sum('photos_count');

        return view('sources.show', compact(
            'source',
            'reviewCount',
            'photoCount'
        ));
    }

    /**
     * Show the form for editing the specified source.
     */
    public function edit(Source $source)
    {
        return view('sources.edit', compact('source'));
    }

    /**
     * Update the specified source.
     */
    public function update(Request $request, Source $source)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'source_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $source->update($validated);

        return redirect()
            ->route('sources.index')
            ->with('success', 'Source updated successfully.');
    }

    /**
     * Remove the specified source.
     */
    public function destroy(Source $source)
    {
        $source->delete();

        return redirect()
            ->route('sources.index')
            ->with('success', 'Source deleted successfully.');
    }
}