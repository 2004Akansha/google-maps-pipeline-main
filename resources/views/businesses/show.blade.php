@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="mb-2">
                <a
                    href="{{ route('businesses.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    ← Back to Businesses
                </a>
            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                {{ $business->name }}
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $business->category ?? 'Business' }}
            </p>

        </div>


        @if($business->maps_url)

            <a
                href="{{ $business->maps_url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Open in Google Maps
            </a>

        @endif

    </div>


    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Rating --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Rating
            </p>

            <div class="mt-2">

                @if($business->rating !== null)

                    <span class="text-2xl font-bold text-gray-900">
                        {{ $business->rating }}
                    </span>

                    <span class="text-sm text-gray-500">
                        / 5
                    </span>

                @else

                    <span class="text-lg font-medium text-gray-400">
                        Not available
                    </span>

                @endif

            </div>

        </div>


        {{-- Google Reviews --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Google Reviews
            </p>

            <div class="mt-2">

                <span class="text-2xl font-bold text-gray-900">
                    {{ $business->review_count }}
                </span>

                <span class="text-sm text-gray-500">
                    reviews
                </span>

            </div>

        </div>


        {{-- Collected Reviews --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Collected Reviews
            </p>

            <div class="mt-2">

                <span class="text-2xl font-bold text-gray-900">
                    {{ $business->reviews_count }}
                </span>

                <a
                    href="{{ route('businesses.reviews', $business) }}"
                    class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    View
                </a>

            </div>

        </div>


        {{-- Photos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-gray-500">
                Photos
            </p>

            <div class="mt-2">

                <span class="text-2xl font-bold text-gray-900">
                    {{ $business->photos_count }}
                </span>

                <a
                    href="{{ route('businesses.photos', $business) }}"
                    class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    View
                </a>

            </div>

        </div>

    </div>


    {{-- Main Grid --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Business Information --}}
        <div class="lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-4">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Business Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Details collected from the source.
                    </p>

                </div>


                <div class="divide-y divide-gray-100">


                    {{-- Name --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Business Name
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">
                            {{ $business->name }}
                        </div>

                    </div>


                    {{-- Category --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Category
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">
                            {{ $business->category ?? '—' }}
                        </div>

                    </div>


                    {{-- Address --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Address
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">
                            {{ $business->address ?? '—' }}
                        </div>

                    </div>

                    {{-- Latitude --}}
<div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
    <div class="text-sm font-medium text-gray-500">
        Latitude
    </div>

    <div class="text-sm text-gray-900 sm:col-span-2">
        {{ $business->latitude ?? '—' }}
    </div>
</div>

{{-- Longitude --}}
<div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
    <div class="text-sm font-medium text-gray-500">
        Longitude
    </div>

    <div class="text-sm text-gray-900 sm:col-span-2">
        {{ $business->longitude ?? '—' }}
    </div>
</div>


                    {{-- Phone --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Phone
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">

                            @if($business->phone)

                                <a
                                    href="tel:{{ $business->phone }}"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    {{ $business->phone }}
                                </a>

                            @else

                                —

                            @endif

                        </div>

                    </div>


                    {{-- Website --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Website
                        </div>

                        <div class="break-all text-sm sm:col-span-2">

                            @if($business->website)

                                <a
                                    href="{{ $business->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    {{ $business->website }}
                                </a>

                            @else

                                <span class="text-gray-400">
                                    —
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Rating --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Rating
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">

                            @if($business->rating !== null)

                                {{ $business->rating }} / 5

                            @else

                                —

                            @endif

                        </div>

                    </div>


                    {{-- Review Count --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Google Review Count
                        </div>

                        <div class="text-sm text-gray-900 sm:col-span-2">
                            {{ $business->review_count }}
                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">

                        <div class="text-sm font-medium text-gray-500">
                            Status
                        </div>

                        <div class="sm:col-span-2">

                            @if($business->status === 'active')

                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800">
                                    Active
                                </span>

                            @else

                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-800">
                                    {{ ucfirst($business->status) }}
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Source & Collection --}}
        <div class="space-y-6">

            {{-- Source --}}
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-4">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Source
                    </h2>

                </div>


                <div class="space-y-4 p-6">

                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            Source Name
                        </p>

                        <p class="mt-1 text-sm font-medium text-gray-900">
                            {{ $business->source->name ?? '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            Source Type
                        </p>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $business->source->source_type ?? '—' }}
                        </p>

                    </div>


                    @if($business->source)

                        <a
                            href="{{ route('sources.show', $business->source) }}"
                            class="inline-flex text-sm font-medium text-blue-600 hover:text-blue-800"
                        >
                            View Source →
                        </a>

                    @endif

                </div>

            </div>


            {{-- Collection Information --}}
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-4">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Collection Information
                    </h2>

                </div>


                <div class="space-y-4 p-6">

                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            External ID
                        </p>

                        <p class="mt-1 break-all text-sm text-gray-700">
                            {{ $business->external_id ?? '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            Collected At
                        </p>

                        <p class="mt-1 text-sm text-gray-700">

                            @if($business->collected_at)

                                {{ $business->collected_at->format('d M Y, h:i A') }}

                            @else

                                —

                            @endif

                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            Added To Database
                        </p>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $business->created_at->format('d M Y, h:i A') }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase text-gray-500">
                            Last Updated
                        </p>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $business->updated_at->format('d M Y, h:i A') }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Data Navigation --}}
    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Reviews --}}
        <a
            href="{{ route('businesses.reviews', $business) }}"
            class="group rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-blue-300 hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Reviews
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        View all collected customer reviews and owner responses.
                    </p>

                </div>

                <span class="text-2xl font-bold text-gray-900">
                    {{ $business->reviews_count }}
                </span>

            </div>

            <div class="mt-4 text-sm font-medium text-blue-600 group-hover:text-blue-800">
                View Reviews →
            </div>

        </a>


        {{-- Photos --}}
        <a
            href="{{ route('businesses.photos', $business) }}"
            class="group rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-blue-300 hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Photos
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        View photos collected from this business.
                    </p>

                </div>

                <span class="text-2xl font-bold text-gray-900">
                    {{ $business->photos_count }}
                </span>

            </div>

            <div class="mt-4 text-sm font-medium text-blue-600 group-hover:text-blue-800">
                View Photos →
            </div>

        </a>

    </div>


    {{-- Google Maps URL --}}
    @if($business->maps_url)

        <div class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                Google Maps URL
            </h2>

            <div class="mt-3 break-all rounded-lg bg-gray-50 p-4 text-sm text-gray-600">
                {{ $business->maps_url }}
            </div>

            <div class="mt-4">

                <a
                    href="{{ $business->maps_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800"
                >
                    Open Google Maps →
                </a>

            </div>

        </div>

    @endif

</div>

@endsection