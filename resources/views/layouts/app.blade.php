<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Google Maps Pipeline' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <a href="{{ route('sources.index') }}"
               class="text-xl font-bold">
                Google Maps Pipeline
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-100 px-4 py-3 text-red-800">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>