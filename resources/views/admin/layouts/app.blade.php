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
            font-family: 'Newsreader', sans-serif;
            background-color: #0b3d2e;
            color: #f8f8f5;
            scroll-behavior: smooth;
        }

        .hero-text {
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

<body class="bg-[#0b3d2e] hero-text ">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
        <aside class="bg-[#0a2e2b] text-gray-200 p-6 shadow-lg transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'w-64' : 'w-20'">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold hero-text gold-gradient overflow-hidden whitespace-nowrap"
                    x-show="sidebarOpen" x-transition>
                    Tarangini Admin
                </h1>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-400 hover:text-white focus:outline-none p-1 rounded">
                    <span x-show="sidebarOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                    </span>
                    <span x-show="!sidebarOpen" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </span>
                </button>
            </div>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-[#0d4837] transition group">
                    <x-heroicon-o-home class="w-6 h-6 flex-shrink-0" />
                    <span class="ml-3 overflow-hidden whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:leave="transition ease-in duration-100">Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-[#0d4837] transition group">
                    <x-heroicon-o-building-storefront class="w-6 h-6 flex-shrink-0" />
                    <span class="ml-3 overflow-hidden whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'" x-transition>Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-[#0d4837] transition group">
                    <x-heroicon-o-tag class="w-6 h-6 flex-shrink-0" />
                    <span class="ml-3 overflow-hidden whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'" x-transition>Categories</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-[#0d4837] transition group">
                    <x-heroicon-o-shopping-cart class="w-6 h-6 flex-shrink-0" />
                    <span class="ml-3 overflow-hidden whitespace-nowrap"
                        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'" x-transition>Orders</span>
                </a>

                <hr class="border-gray-700 my-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center px-4 py-2 rounded text-red-400 hover:bg-red-900/50 hover:text-red-300 transition group">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6 flex-shrink-0" />
                        <span class="ml-3 overflow-hidden whitespace-nowrap"
                            :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'" x-transition>Log Out</span>
                    </a>
                </form>
            </nav>
        </aside>
        <main class="flex-grow p-8 transition-all duration-300 ease-in-out">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>

</html>
