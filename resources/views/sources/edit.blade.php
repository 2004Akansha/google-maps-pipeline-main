@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">

        <a href="{{ route('sources.index') }}"
           class="text-sm text-gray-500 hover:text-gray-800">
            ← Back to Sources
        </a>

        <h1 class="text-3xl font-bold mt-3">
            Edit Source
        </h1>

        <p class="text-gray-500 mt-1">
            Update source information.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm border p-8">

        <form action="{{ route('sources.update', $source) }}"
              method="POST">

            @csrf
            @method('PUT')


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Source Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $source->name) }}"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

            </div>


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Website URL
                </label>

                <input
                    type="url"
                    name="website_url"
                    value="{{ old('website_url', $source->website_url) }}"
                    class="w-full border rounded-lg px-4 py-3"
                >

            </div>


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Source Type
                </label>

                <select
                    name="source_type"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

                    <option value="Google Maps"
                        {{ $source->source_type === 'Google Maps' ? 'selected' : '' }}>
                        Google Maps
                    </option>

                    <option value="Website"
                        {{ $source->source_type === 'Website' ? 'selected' : '' }}>
                        Website
                    </option>

                    <option value="Other"
                        {{ $source->source_type === 'Other' ? 'selected' : '' }}>
                        Other
                    </option>

                </select>

            </div>


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border rounded-lg px-4 py-3"
                >{{ old('description', $source->description) }}</textarea>

            </div>


            <div class="mb-8">

                <label class="block font-medium mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

                    <option value="active"
                        {{ $source->status === 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ $source->status === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="bg-black text-white px-6 py-3 rounded-lg">

                Update Source

            </button>

        </form>

    </div>

</div>

@endsection