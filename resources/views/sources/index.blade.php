@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold">
            Sources
        </h1>

        <p class="text-gray-500 mt-1">
            Manage your data sources.
        </p>
    </div>

    <a href="{{ route('sources.create') }}"
       class="bg-black text-white px-5 py-3 rounded-lg hover:bg-gray-800">
        + Add Source
    </a>

</div>


<div class="bg-white rounded-xl shadow-sm border overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50 border-b">

            <tr>
                <th class="text-left px-6 py-4 font-semibold">
                    Name
                </th>

                <th class="text-left px-6 py-4 font-semibold">
                    Type
                </th>

                <th class="text-left px-6 py-4 font-semibold">
                    Status
                </th>

                <th class="text-right px-6 py-4 font-semibold">
                    Actions
                </th>
            </tr>

        </thead>

        <tbody>

            @forelse($sources as $source)

                <tr class="border-b last:border-b-0 hover:bg-gray-50">

                    <td class="px-6 py-4">

                        <a href="{{ route('sources.show', $source) }}"
                           class="font-medium text-blue-600 hover:underline">

                            {{ $source->name }}

                        </a>

                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ $source->source_type }}
                    </td>

                    <td class="px-6 py-4">

                        @if($source->status === 'active')

                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                                Active
                            </span>

                        @else

                            <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-600">
                                Inactive
                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-4 text-right">

                        <a href="{{ route('sources.edit', $source) }}"
                           class="text-blue-600 hover:underline mr-4">
                            Edit
                        </a>

                        <form action="{{ route('sources.destroy', $source) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Delete this source?')"
                                    class="text-red-600 hover:underline">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4"
                        class="px-6 py-12 text-center text-gray-500">

                        No sources found.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection