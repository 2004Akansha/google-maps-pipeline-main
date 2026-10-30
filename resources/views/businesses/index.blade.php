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

    {{-- Search and Filter --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <form method="GET" action="{{ route('businesses.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-3">

            {{-- Search --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search business, category, address..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            {{-- Source --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Source
                </label>

                <select
                    name="source_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">All Sources</option>

                    @foreach($sources as $source)

                        <option
                            value="{{ $source->id }}"
                            {{ request('source_id') == $source->id ? 'selected' : '' }}
                        >
                            {{ $source->name }}
                        </option>

                    @endforeach

                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Search
                </button>

                <a
                    href="{{ route('businesses.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Businesses Table --}}
    @if($businesses->count())

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

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
                                <td class="px-6 py-4 text-sm text-gray-700">

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


                                {{-- Source --}}
                                <td class="px-6 py-4 text-sm text-gray-700">

                                    {{ $business->source->name ?? '—' }}

                                </td>


                                {{-- Action --}}
                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('businesses.show', $business) }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        <div class="mt-6">

            {{ $businesses->links() }}

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

@endsection