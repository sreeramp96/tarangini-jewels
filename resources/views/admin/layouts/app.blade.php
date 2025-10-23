<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tarangini Jewels</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-gray-800 text-white p-6 shadow-lg">
            <h1 class="text-2xl font-bold hero-text gold-gradient mb-6">
                Tarangini Admin
            </h1>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded hover:bg-gray-700 transition">Dashboard</a>
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 rounded hover:bg-gray-700 transition">Products</a>
                <a href="{{ route('categories.index') }}"
                    class="px-4 py-2 rounded hover:bg-gray-700 transition">Categories</a>
                {{-- ... other links ... --}}
            </nav>
        </aside>

        <main class="flex-grow p-8">
            @yield('content')
        </main>
    </div>

</body>

</html>
