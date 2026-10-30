@extends('layouts.app')

@section('content')

<div class="mb-8">

    <a href="{{ route('sources.index') }}"
       class="text-sm text-gray-500 hover:text-gray-800">
        ← Back to Sources
    </a>

    <a href="{{ route('extraction-jobs.create', $source) }}"
   class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
    + New Extraction
</a>

    <div class="flex items-center justify-between mt-4">

        <div>

            <h1 class="text-3xl font-bold">
                {{ $source->name }}
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $source->description }}
            </p>

        </div>


        <a href="{{ route('sources.edit', $source) }}"
           class="border px-5 py-3 rounded-lg hover:bg-gray-50">

            Edit Source

        </a>

    </div>

</div>


{{-- Statistics --}}

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">


    <div class="bg-white border rounded-xl p-6">

        <p class="text-gray-500 text-sm">
            Businesses
        </p>

        <p class="text-3xl font-bold mt-2">
           {{ number_format($source->businesses_count) }}
        </p>

    </div>


    <div class="bg-white border rounded-xl p-6">

        <p class="text-gray-500 text-sm">
            Reviews
        </p>

        <p class="text-3xl font-bold mt-2">
            {{ number_format($reviewCount) }}
        </p>

    </div>


    <div class="bg-white border rounded-xl p-6">

        <p class="text-gray-500 text-sm">
            Photos
        </p>

        <p class="text-3xl font-bold mt-2">
            {{ number_format($photoCount) }}
        </p>

    </div>


    <div class="bg-white border rounded-xl p-6">

        <p class="text-gray-500 text-sm">
            Jobs
        </p>

        <p class="text-3xl font-bold mt-2">
            0
        </p>

    </div>

</div>


{{-- Workspace navigation --}}

<div class="bg-white border rounded-xl p-6">

    <h2 class="text-xl font-semibold mb-5">
        Source Workspace
    </h2>


    <div class="flex flex-wrap gap-3">

        <button
            class="px-5 py-3 rounded-lg bg-black text-white">
            Businesses
        </button>

        <button
            class="px-5 py-3 rounded-lg border text-gray-400 cursor-not-allowed">
            Reviews
        </button>

        <button
            class="px-5 py-3 rounded-lg border text-gray-400 cursor-not-allowed">
            Photos
        </button>

        <button
            class="px-5 py-3 rounded-lg border text-gray-400 cursor-not-allowed">
            Jobs
        </button>

    </div>

</div>


{{-- Source information --}}

<div class="bg-white border rounded-xl p-6 mt-6">

    <h2 class="text-xl font-semibold mb-5">
        Source Information
    </h2>


    <div class="grid md:grid-cols-2 gap-6">

        <div>

            <p class="text-sm text-gray-500">
                Source Name
            </p>

            <p class="font-medium mt-1">
                {{ $source->name }}
            </p>

        </div>


        <div>

            <p class="text-sm text-gray-500">
                Source Type
            </p>

            <p class="font-medium mt-1">
                {{ $source->source_type }}
            </p>

        </div>


        <div>

            <p class="text-sm text-gray-500">
                Website
            </p>

            @if($source->website_url)

                <a
                    href="{{ $source->website_url }}"
                    target="_blank"
                    class="text-blue-600 hover:underline">

                    {{ $source->website_url }}

                </a>

            @else

                <p class="mt-1 text-gray-400">
                    Not provided
                </p>

            @endif

        </div>


        <div>

            <p class="text-sm text-gray-500">
                Status
            </p>

            <p class="font-medium mt-1">
                {{ ucfirst($source->status) }}
            </p>

        </div>

    </div>

</div>

@endsection