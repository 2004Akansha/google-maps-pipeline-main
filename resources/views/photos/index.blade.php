@extends('layouts.app')

@section('content')

<div class="mb-8">

    <a
        href="{{ route('businesses.show', $business) }}"
        class="text-sm text-gray-500 hover:text-gray-800">

        ← Back to Business

    </a>

    <div class="mt-4">

        <h1 class="text-3xl font-bold">
            Photos
        </h1>

        <p class="text-gray-500 mt-1">
            {{ $business->name }}
        </p>

    </div>

</div>


{{-- Photo count --}}

<div class="bg-white border rounded-xl p-6 mb-6">

    <p class="text-sm text-gray-500">
        Total Photos
    </p>

    <p class="text-3xl font-bold mt-1">
        {{ number_format($photos->total()) }}
    </p>

</div>


{{-- Photo grid --}}

@if($photos->count())

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

        @foreach($photos as $photo)

            <a
                href="{{ $photo->photo_url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="group block bg-white border rounded-xl overflow-hidden">

                <div class="aspect-square bg-gray-100 overflow-hidden">

                    <img
                        src="{{ $photo->photo_url }}"
                        alt="{{ $business->name }}"
                        loading="lazy"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                    >

                </div>

                <div class="px-4 py-3">

                    <p class="text-sm text-gray-500">
                        Open original
                    </p>

                </div>

            </a>

        @endforeach

    </div>

@else

    <div class="bg-white border rounded-xl p-12 text-center">

        <h2 class="text-lg font-semibold">
            No photos yet
        </h2>

        <p class="text-gray-500 mt-2">
            Photos collected from the Chrome extractor
            will appear here.
        </p>

    </div>

@endif


{{-- Pagination --}}

@if($photos->hasPages())

    <div class="mt-6">

        {{ $photos->links() }}

    </div>

@endif

@endsection