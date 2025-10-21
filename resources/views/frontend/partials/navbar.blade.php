{{-- <header
    class="flex justify-between items-center px-6 lg:px-20 py-4 bg-[#0b3d2e]/90 backdrop-blur-md sticky top-0 z-50 border-b border-[#d4af37]/30">
    <a href="{{ url('/') }}" class="flex items-center space-x-2">
        <img src="{{ asset('storage/Images/logo.png') }}" alt="Tarangini Jewels Logo"
            class="h-10 lg:h-14 w-auto object-contain">
        <span class="text-2xl lg:text-3xl font-bold hero-text gold-gradient">Tarangini Jewels</span>
    </a>

    <nav class="space-x-4 text-sm hidden sm:block">
        <a href="#collections" class="hover:text-[#d4af37] transition hero-text ">Collections</a>
        <a href="#about" class="hover:text-[#d4af37] transition hero-text ">About</a>
        <a href="#contact" class="hover:text-[#d4af37] transition hero-text ">Contact</a>
        @auth
        <a href="{{ url('/dashboard') }}"
            class="px-4 py-1 border border-[#d4af37] rounded hover:bg-[#d4af37] hover:text-[#0b3d2e] transition hero-text ">
            Dashboard
        </a>
        @else
        <a href="{{ route('login') }}"
            class="px-4 py-1 border border-[#d4af37] rounded hover:bg-[#d4af37] hover:text-[#0b3d2e] transition hero-text ">
            Login
        </a>
        <a href="{{ route('register') }}"
            class="px-4 py-1 border border-[#d4af37] rounded hover:bg-[#d4af37] hover:text-[#0b3d2e] transition hero-text ">
            Register
        </a>
        @endauth
    </nav>
</header> --}}

{{-- The main header container is now a column, but still sticky --}}
<header class="flex flex-col bg-[#0b3d2e]/90 backdrop-blur-md sticky top-0 z-50 shadow-md">

    <div class="flex justify-between items-center w-full px-6 lg:px-20 py-3">

        <a href="{{ url('/') }}" class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('storage/Images/logo.png') }}" alt="Tarangini Jewels Logo"
                class="h-10 lg:h-12 w-auto object-contain">
            {{-- We can hide the text on smaller screens if needed --}}
            <span class="text-xl lg:text-3xl font-bold hero-text gold-gradient hidden md:block">
                Tarangini Jewels
            </span>
        </a>

        <div class="relative w-full max-w-lg mx-4 hidden md:block">
            <input type="text" placeholder="Search for Gold Jewellery, Diamond Jewellery..."
                class="w-full px-4 py-2 text-sm bg-white/10 border border-[#d4af37]/30 rounded-full text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#d4af37]">
            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-[#d4af37]" />
            </div>
        </div>

        <nav class="flex items-center space-x-4 lg:space-x-6">
            {{-- Wishlist Icon --}}
            <a href="#" class="text-gray-200 hover:text-[#d4af37] transition">
                <span class="sr-only">Wishlist</span>
                <x-heroicon-o-heart class="w-6 h-6" />
            </a>

            {{-- Cart Icon --}}
            <a href="#" class="relative text-gray-200 hover:text-[#d4af37] transition">
                <span class="sr-only">Cart</span>
                <x-heroicon-o-shopping-bag class="w-6 h-6" />
                <span
                    class="absolute -top-2 -right-2 w-4 h-4 text-xs font-bold bg-[#d4af37] text-[#0b3d2e] rounded-full flex items-center justify-center">0</span>
            </a>

            {{-- Auth: Login/Register or Dashboard Icon --}}
            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-200 hover:text-[#d4af37] transition">
                    <span class="sr-only">Dashboard</span>
                    <x-heroicon-o-user-circle class="w-6 h-6" />
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-200 hover:text-[#d4af37] transition">
                    <span class="sr-only">Login</span>
                    <x-heroicon-o-user class="w-6 h-6" />
                </a>
            @endauth
        </nav>
    </div>

    <nav class="w-full flex justify-center items-center py-3 bg-[#0a2e2b] border-y border-[#d4af37]/30">
        <div class="flex items-center space-x-6 lg:space-x-10 text-sm hero-text">
            {{-- A helper class for the nav links --}}
            @php
                $navLinkClasses = 'flex flex-col items-center text-gray-200 hover:text-[#d4af37] transition';
            @endphp

            <a href="#collections" class="{{ $navLinkClasses }}">
                <x-heroicon-o-sparkles class="w-6 h-6 mb-1" />
                <span>Collections</span>
            </a>
            <a href="#" class="{{ $navLinkClasses }}">
                <x-heroicon-o-viewfinder-circle class="w-6 h-6 mb-1" /> {{-- Example icon --}}
                <span>Rings</span>
            </a>
            <a href="#" class="{{ $navLinkClasses }}">
                <x-heroicon-o-star class="w-6 h-6 mb-1" /> {{-- Example icon --}}
                <span>Earrings</span>
            </a>
            <a href="#" class="{{ $navLinkClasses }}">
                <x-heroicon-o-link class="w-6 h-6 mb-1" /> {{-- Example icon --}}
                <span>Necklaces</span>
            </a>
            <a href="#about" class="{{ $navLinkClasses }}">
                <x-heroicon-o-information-circle class="w-6 h-6 mb-1" />
                <span>About</span>
            </a>
            <a href="#contact" class="{{ $navLinkClasses }}">
                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 mb-1" />
                <span>Contact</span>
            </a>
        </div>
    </nav>
</header>