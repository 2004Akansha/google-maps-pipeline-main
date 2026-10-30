<?php

namespace App\Http\Controllers;

use App\Models\ExtractionJob;
use App\Models\Source;
use Illuminate\Http\Request;

class ExtractionJobController extends Controller
{
    public function index()
    {
        $jobs = ExtractionJob::with('source')
            ->latest()
            ->paginate(10);

        return view('extraction-jobs.index', compact('jobs'));
    }

    public function create(Source $source)
    {
        return view('extraction-jobs.create', compact('source'));
    }

    public function store(Request $request, Source $source)
    {
        $validated = $request->validate([
            'search_query' => ['required','string','max:255'],
            'collect_business_details' => ['nullable','boolean'],
            'collect_reviews' => ['nullable','boolean'],
            'collect_full_reviews' => ['nullable','boolean'],
            'collect_photos' => ['nullable','boolean'],
        ]);

        $job = ExtractionJob::create([
            'source_id' => $source->id,

            'search_query' => $validated['search_query'],

            'collect_business_details' =>
                $request->boolean('collect_business_details'),

            'collect_reviews' =>
                $request->boolean('collect_reviews'),

            'collect_full_reviews' =>
                $request->boolean('collect_full_reviews'),

            'collect_photos' =>
                $request->boolean('collect_photos'),

            'status' => 'pending',

            'total_businesses' => 0,
            'processed_businesses' => 0,
            'successful_businesses' => 0,
            'failed_businesses' => 0,
        ]);

        return redirect()
            ->route('extraction-jobs.show', $job)
            ->with('success', 'Extraction job created successfully.');
    }

    public function show(ExtractionJob $extractionJob)
    {
        $extractionJob->load('source');

        return view(
            'extraction-jobs.show',
            compact('extractionJob')
        );
    }
}