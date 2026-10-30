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
            Reviews
        </h1>

        <p class="text-gray-500 mt-1">
            {{ $business->name }}
        </p>

    </div>

</div>


{{-- Review summary --}}

<div class="bg-white border rounded-xl p-6 mb-6">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-sm text-gray-500">
                Total Reviews
            </p>

            <p class="text-3xl font-bold mt-1">
                {{ number_format($business->reviews()->count()) }}
            </p>

        </div>


        @if($business->rating !== null)

            <div class="text-right">

                <p class="text-3xl font-bold">
                    {{ $business->rating }}
                    <span class="text-yellow-500">★</span>
                </p>

                <p class="text-sm text-gray-500">
                    Business Rating
                </p>

            </div>

        @endif

    </div>

</div>


{{-- Reviews --}}

<div class="space-y-4">

    @forelse($reviews as $review)

        <div class="bg-white border rounded-xl p-6">

            <div class="flex items-start justify-between gap-4">


                {{-- Author --}}

                <div>

                    <h2 class="font-semibold text-lg">
                        {{ $review->author }}
                    </h2>

                    @if($review->review_date)

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $review->review_date->diffForHumans() }}
                        </p>

                    @endif

                </div>


                {{-- Rating --}}

                @if($review->rating !== null)

                    <div class="text-lg whitespace-nowrap">

                        <span class="text-yellow-500">
                            {{ str_repeat('★', (int) $review->rating) }}
                        </span>

                        <span class="text-gray-300">
                            {{ str_repeat('★', 5 - (int) $review->rating) }}
                        </span>

                    </div>

                @endif

            </div>


            {{-- Review text --}}

            @if($review->review_text)

                <p class="mt-4 text-gray-700 leading-7">
                    {{ $review->review_text }}
                </p>

            @endif


            {{-- Owner response --}}

            @if($review->owner_response)

                <div class="mt-5 ml-4 border-l-4 border-gray-200 pl-4">

                    <p class="text-sm font-semibold">
                        Owner response
                    </p>

                    <p class="text-sm text-gray-600 mt-1 leading-6">
                        {{ $review->owner_response }}
                    </p>

                </div>

            @endif

        </div>

    @empty

        <div class="bg-white border rounded-xl p-12 text-center">

            <h2 class="text-lg font-semibold">
                No reviews yet
            </h2>

            <p class="text-gray-500 mt-2">
                Reviews collected from the Chrome extractor
                will appear here.
            </p>

        </div>

    @endforelse

</div>


{{-- Pagination --}}

@if($reviews->hasPages())

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>

@endif

@endsection