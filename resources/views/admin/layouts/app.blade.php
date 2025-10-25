<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tarangini Jewels</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0b3d2e;
            color: #f8f8f5;
            scroll-behavior: smooth;
        }

        .hero-text {
            /* font-family: 'Playfair Display', serif; */
            font-family: "Newsreader", serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }

        /* Gold Gradient Text */
        .gold-gradient {
            background: linear-gradient(90deg, #d4af37, #f9e6b3, #d4af37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shimmer 5s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        /* Glow hover effect */
        .glow-hover:hover {
            box-shadow: 0 0 25px #d4af3775;
            transform: translateY(-3px);
        }

        /* Button animation */
        .btn-gold {
            background-color: #d4af37;
            color: #0b3d2e;
            transition: all 0.3s ease-in-out;
        }

        .btn-gold:hover {
            background-color: #f1cf73;
            box-shadow: 0 0 20px #d4af3775;
        }
    </style>
</head>

<body class="bg-[#0b3d2e] hero-text">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#0a2e2b] text-gray-200 p-6 shadow-lg">
            <h1 class="text-2xl font-bold hero-text gold-gradient mb-6">
                Tarangini Admin
            </h1>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-4 py-2 rounded hover:bg-[#0d4837] transition">Dashboard</a>
                <a href="{{ route('admin.products.index') }}"
                    class="px-4 py-2 rounded hover:bg-[#0d4837] transition">Products</a>
                <a href="{{ route('admin.categories.index') }}"
                    class="px-4 py-2 rounded hover:bg-[#0d4837] transition">Categories</a>
                <a href="#" class="px-4 py-2 rounded hover:bg-[#0d4837] transition">Orders</a>

                <hr class="border-gray-700 my-4">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="px-4 py-2 rounded text-red-400 hover:bg-red-900/50 hover:text-red-300 transition block">
                        Log Out
                    </a>
                </form>
            </nav>
        </aside>

        <main class="flex-grow p-8">
            @yield('content')
        </main>
    </div>

    @yield('scripts')

</body>

</html>