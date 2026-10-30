@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Extraction Jobs
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage Google Maps extraction jobs.
        </p>
    </div>


    @if($jobs->count())

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            ID
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            Source
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            Search
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            Progress
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-medium uppercase text-gray-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 bg-white">

                    @foreach($jobs as $job)

                        <tr>

                            <td class="px-6 py-4 text-sm text-gray-900">
                                #{{ $job->id }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $job->source->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $job->search_query }}
                            </td>

                            <td class="px-6 py-4">

                                @if($job->status === 'pending')

                                    <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800">
                                        Pending
                                    </span>

                                @elseif($job->status === 'running')

                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-800">
                                        Running
                                    </span>

                                @elseif($job->status === 'completed')

                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800">
                                        Completed
                                    </span>

                                @elseif($job->status === 'failed')

                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800">
                                        Failed
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-800">
                                        {{ ucfirst($job->status) }}
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $job->processed_businesses }}
                                /
                                {{ $job->total_businesses }}

                            </td>

                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('extraction-jobs.show', $job) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800">

                                    View

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="mt-6">
            {{ $jobs->links() }}
        </div>

    @else

        <div class="rounded-xl border border-gray-200 bg-white p-10 text-center">

            <h2 class="text-lg font-semibold text-gray-900">
                No extraction jobs yet
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Create an extraction from a source to get started.
            </p>

        </div>

    @endif

</div>

@endsection