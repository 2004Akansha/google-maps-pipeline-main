@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Businesses
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage businesses collected from your sources.
        </p>
    </div>

   {{-- Advanced Search and Filters --}}
<div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">
            Search and Filters
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Find businesses using keywords, category or source.
        </p>
    </div>

   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

        {{-- Keyword Search --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Search Businesses
            </label>

            <input
                type="text"
                id="keywordSearch"
                placeholder="Name, address, phone..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
            >
        </div>

        {{-- Category Filter --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Category
            </label>

            <select
                id="categoryFilter"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
            >
                <option value="">All Categories</option>

                @foreach($businesses->pluck('category')->filter()->unique()->sort() as $category)
                    <option value="{{ $category }}">
                        {{ $category }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- Source Filter --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
                Source
            </label>

            <select
                id="sourceFilter"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
            >
                <option value="">All Sources</option>

                @foreach($sources as $source)
                    <option value="{{ $source->name }}">
                        {{ $source->name }}
                    </option>
                @endforeach

            </select>
        </div>
        <div>
    <label for="ratingFilter" class="block text-sm font-medium mb-1">
        Rating
    </label>

    <select id="ratingFilter"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
        <option value="">All Ratings</option>
        <option value="4.5">4.5+ Stars</option>
        <option value="4">4+ Stars</option>
        <option value="3">3+ Stars</option>
        <option value="2">2+ Stars</option>
        <option value="1">1+ Stars</option>
    </select>
</div>

        {{-- Reset --}}
        <div class="flex items-end">

            <button
                type="button"
                id="resetFilters"
                class="w-full rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Clear Filters
            </button>

        </div>

    </div>

</div>


    {{-- Businesses Table --}}
    @if($businesses->count())

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table
    id="businessesTable"
    class="min-w-full divide-y divide-gray-200"
>

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Business
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Category
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Address
                            </th>

                            {{-- Latitude --}}
<th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
    Latitude
</th>

{{-- Longitude --}}
<th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
    Longitude
</th>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Phone
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Rating
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                Source
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-medium uppercase text-gray-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200 bg-white">

                        @foreach($businesses as $business)

                            <tr class="hover:bg-gray-50">

                                {{-- Business --}}
                                <td class="px-6 py-4">

                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $business->name }}
                                    </div>

                                    @if($business->website)
                                        <div class="mt-1 text-xs text-gray-500">
                                            {{ $business->website }}
                                        </div>
                                    @endif

                                </td>


                                {{-- Category --}}
                                <td class="px-6 py-4 text-sm text-gray-700"
    data-search="{{ $business->category ?? '' }}">
    {{ $business->category ?? '—' }}
</td>


                                {{-- Address --}}
                                <td class="max-w-xs px-6 py-4 text-sm text-gray-700">

                                    <div class="truncate">
                                        {{ $business->address ?? '—' }}
                                    </div>

                                </td>

                                {{-- Latitude --}}
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
    {{ $business->latitude ?? '—' }}
</td>

{{-- Longitude --}}
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
    {{ $business->longitude ?? '—' }}
</td>


                                {{-- Phone --}}
                                <td class="px-6 py-4 text-sm text-gray-700">

                                    {{ $business->phone ?? '—' }}

                                </td>


                                {{-- Rating --}}
                                <td class="px-6 py-4">

                                    @if($business->rating !== null)

                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $business->rating }}
                                        </span>

                                        <span class="text-xs text-gray-500">
                                            / 5
                                        </span>

                                    @else

                                        <span class="text-sm text-gray-400">
                                            —
                                        </span>

                                    @endif

                                </td>


                                <td class="px-6 py-4 text-sm text-gray-700"
    data-search="{{ $business->source->name ?? '' }}">
    {{ $business->source->name ?? '—' }}
</td>


                                {{-- Action --}}
<td class="px-6 py-4">

    <div class="flex items-center justify-end gap-3">

        {{-- View Button --}}
        <a
            href="{{ route('businesses.show', $business) }}"
            class="text-sm font-medium text-blue-600 hover:text-blue-800"
        >
            View
        </a>

        {{-- Download ZIP Button --}}
        <a
            href="{{ route('businesses.download-zip', $business) }}"
            class="inline-flex items-center rounded-lg bg-green-600 px-3 py-2 text-xs font-medium text-white hover:bg-green-700"
        >
            Download ZIP
        </a>

    </div>

</td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


    @else

        <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">

            <h2 class="text-lg font-semibold text-gray-900">
                No businesses found
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Businesses imported from Google Maps will appear here.
            </p>

        </div>

    @endif

</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tableElement = document.querySelector('#businessesTable');

    if (!tableElement) {
        return;
    }

    // Check whether DataTables loaded successfully
    if (typeof DataTable === 'undefined') {
        console.error('DataTables JavaScript is not loaded.');
        return;
    }

    // Initialize DataTables
    const table = new DataTable('#businessesTable', {

        paging: false,
        searching: true,
        ordering: true,
        info: false,
        lengthChange: false,

        order: [],

        // Show information above the table
        layout: {
            topStart: 'info',
            topEnd: null,
            bottomStart: null,
            bottomEnd: null
        },

        // Action column is the 9th column (index 8)
        columnDefs: [
            {
                targets: 8,
                orderable: false,
                searchable: false
            }
        ],

        language: {
            zeroRecords: "No matching businesses found",
            emptyTable: "No businesses available"
        }
    });

    // Keyword Search
    const keywordSearch = document.getElementById('keywordSearch');

    keywordSearch.addEventListener('input', function () {
        table.search(this.value).draw();
    });

    // Category Filter
    const categoryFilter = document.getElementById('categoryFilter');

    categoryFilter.addEventListener('change', function () {

        const value = this.value;

        table
            .column(1)
            .search(
                value ? '^' + escapeRegex(value) + '$' : '',
                true,
                false
            )
            .draw();
    });

    // Source Filter
    const sourceFilter = document.getElementById('sourceFilter');

    sourceFilter.addEventListener('change', function () {

        const value = this.value;

        table
            .column(7)
            .search(
                value ? '^' + escapeRegex(value) + '$' : '',
                true,
                false
            )
            .draw();
    });

    // Rating filter
document.getElementById('ratingFilter').addEventListener('change', function () {
    const minRating = parseFloat(this.value);

    table.search.fixed('ratingFilter', function (searchStr, rowData) {
        if (isNaN(minRating)) {
            return true;
        }

        const ratingText = String(rowData[6] ?? '')
            .replace(/<[^>]*>/g, '')
            .trim();

        const rating = parseFloat(ratingText);

        return !isNaN(rating) && rating >= minRating;
    });

    table.draw();
});

    // Reset All Filters
    document.getElementById('resetFilters')
        .addEventListener('click', function () {

            keywordSearch.value = '';
            categoryFilter.value = '';
            sourceFilter.value = '';

            table.search('');
            table.columns().search('');
            table.draw();
        });

    // Correct regex escaping
    function escapeRegex(value) {
        return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

});
</script>
@endpush



@endsection