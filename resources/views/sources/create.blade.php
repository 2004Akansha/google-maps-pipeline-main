@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">

        <a href="{{ route('sources.index') }}"
           class="text-sm text-gray-500 hover:text-gray-800">
            ← Back to Sources
        </a>

        <h1 class="text-3xl font-bold mt-3">
            Add Source
        </h1>

        <p class="text-gray-500 mt-1">
            Add a new data source to your pipeline.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm border p-8">

        <form action="{{ route('sources.store') }}"
              method="POST">

            @csrf


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Source Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Google Maps"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:outline-none"
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
                    value="{{ old('website_url') }}"
                    placeholder="https://www.google.com/maps"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:outline-none"
                >

            </div>


            <div class="mb-6">

                <label class="block font-medium mb-2">
                    Source Type
                </label>

                <select
                    name="source_type"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:outline-none"
                    required
                >

                    <option value="">Select source type</option>

                    <option value="Google Maps"
                        {{ old('source_type') === 'Google Maps' ? 'selected' : '' }}>
                        Google Maps
                    </option>

                    <option value="Website"
                        {{ old('source_type') === 'Website' ? 'selected' : '' }}>
                        Website
                    </option>

                    <option value="Other"
                        {{ old('source_type') === 'Other' ? 'selected' : '' }}>
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
                    placeholder="Google Maps business data"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:outline-none"
                >{{ old('description') }}</textarea>

            </div>


            <div class="mb-8">

                <label class="block font-medium mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-black focus:outline-none"
                    required
                >

                    <option value="active"
                        {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ old('status') === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>


            <div class="flex items-center gap-3">

                <button
                    type="submit"
                    class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">

                    Save Source

                </button>


                <a href="{{ route('sources.index') }}"
                   class="px-6 py-3 rounded-lg border hover:bg-gray-50">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection