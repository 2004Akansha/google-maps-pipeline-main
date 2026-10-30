@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('sources.show', $source) }}"
           class="text-sm text-gray-500 hover:text-gray-700">
            ← Back to {{ $source->name }}
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            New Extraction
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Create a new Google Maps extraction job.
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form method="POST"
              action="{{ route('extraction-jobs.store', $source) }}">

            @csrf

            {{-- Source --}}

            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700">
                    Source
                </label>

                <div class="mt-2 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <div class="font-medium text-gray-900">
                        {{ $source->name }}
                    </div>

                    <div class="text-sm text-gray-500">
                        {{ $source->source_type }}
                    </div>
                </div>

            </div>


            {{-- Search --}}

            <div class="mb-6">

                <label for="search_query"
                       class="block text-sm font-medium text-gray-700">

                    Search

                </label>

                <input
                    type="text"
                    id="search_query"
                    name="search_query"
                    value="{{ old('search_query') }}"
                    placeholder="restaurants in Nagpur"
                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                >

                @error('search_query')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Options --}}

            <div class="mb-6">

                <h2 class="text-sm font-medium text-gray-700">
                    Options
                </h2>

                <div class="mt-3 space-y-3">

                    {{-- Business Details --}}

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="collect_business_details"
                            value="1"
                            checked
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm text-gray-700">
                            Business Details
                        </span>

                    </label>


                    {{-- Reviews --}}

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="collect_reviews"
                            value="1"
                            checked
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm text-gray-700">
                            Reviews
                        </span>

                    </label>


                    {{-- Photos --}}

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="collect_photos"
                            value="1"
                            checked
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm text-gray-700">
                            Photos
                        </span>

                    </label>

                </div>

            </div>


            {{-- Buttons --}}

            <div class="flex items-center gap-3">

                <a href="{{ route('sources.show', $source) }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">

                    Start Extraction

                </button>

            </div>

        </form>

    </div>

</div>

@endsection