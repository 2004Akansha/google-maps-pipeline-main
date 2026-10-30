@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-6">

        <a href="{{ route('extraction-jobs.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700">

            ← Back to Extraction Jobs

        </a>

        <div class="mt-3 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold text-gray-900">
                    Extraction Job #{{ $extractionJob->id }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $extractionJob->source->name }}
                </p>

            </div>

        </div>

    </div>


    <div class="grid gap-6 md:grid-cols-2">


        {{-- Job Information --}}

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Job Information
            </h2>

            <dl class="mt-5 space-y-4">

                <div>
                    <dt class="text-sm text-gray-500">
                        Source
                    </dt>

                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $extractionJob->source->name }}
                    </dd>
                </div>


                <div>
                    <dt class="text-sm text-gray-500">
                        Search
                    </dt>

                    <dd class="mt-1 font-medium text-gray-900">
                        {{ $extractionJob->search_query }}
                    </dd>
                </div>


                <div>
                    <dt class="text-sm text-gray-500">
                        Status
                    </dt>

                    <dd class="mt-1 font-medium text-gray-900">
                        {{ ucfirst($extractionJob->status) }}
                    </dd>
                </div>


                <div>
                    <dt class="text-sm text-gray-500">
                        Created
                    </dt>

                    <dd class="mt-1 text-gray-700">
                        {{ $extractionJob->created_at->format('d M Y, h:i A') }}
                    </dd>
                </div>

            </dl>

        </div>


        {{-- Options --}}

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Extraction Options
            </h2>

            <div class="mt-5 space-y-3">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-600">
                        Business Details
                    </span>

                    <span class="font-medium">
                        {{ $extractionJob->collect_business_details ? 'Enabled' : 'Disabled' }}
                    </span>

                </div>


                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-600">
                        Reviews
                    </span>

                    <span class="font-medium">
                        {{ $extractionJob->collect_reviews ? 'Enabled' : 'Disabled' }}
                    </span>

                </div>


                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-600">
                        Photos
                    </span>

                    <span class="font-medium">
                        {{ $extractionJob->collect_photos ? 'Enabled' : 'Disabled' }}
                    </span>

                </div>

            </div>

        </div>


        {{-- Progress --}}

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm md:col-span-2">

            <h2 class="text-lg font-semibold text-gray-900">
                Progress
            </h2>

            <div class="mt-5 grid gap-4 md:grid-cols-4">

                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-sm text-gray-500">
                        Total
                    </div>

                    <div class="mt-1 text-2xl font-bold">
                        {{ $extractionJob->total_businesses }}
                    </div>
                </div>


                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-sm text-gray-500">
                        Processed
                    </div>

                    <div class="mt-1 text-2xl font-bold">
                        {{ $extractionJob->processed_businesses }}
                    </div>
                </div>


                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-sm text-gray-500">
                        Successful
                    </div>

                    <div class="mt-1 text-2xl font-bold text-green-600">
                        {{ $extractionJob->successful_businesses }}
                    </div>
                </div>


                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-sm text-gray-500">
                        Failed
                    </div>

                    <div class="mt-1 text-2xl font-bold text-red-600">
                        {{ $extractionJob->failed_businesses }}
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection