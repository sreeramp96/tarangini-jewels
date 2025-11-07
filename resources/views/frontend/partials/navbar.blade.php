<header class="flex flex-col bg-[#0b3d2e]/90 backdrop-blur-md sticky top-0 z-50 shadow-md">
    <div class="flex justify-between items-center w-full px-6 lg:px-20 py-4">

        <a href="{{ url('/') }}" class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Tarangini Jewels Logo"
                class="h-10 lg:h-12 w-auto object-contain">
            <span class="text-xl lg:text-3xl font-bold hero-text gold-gradient hidden md:block">
                Tarangini Jewels
            </span>
        </a>

        <nav class="hidden md:flex items-center space-x-8 text-md font-medium">
            <a href="{{ route('home') }}" ...>Home</a>
            <a href="{{ route('categories.show', 'gold-rings') }}" ...>Rings</a>
            <a href="{{ route('categories.show', 'diamond-necklaces') }}" ...>Necklaces</a>
            <a href="{{ url('/#about') }}" class="text-gray-200 hover:text-brand-gold transition">About</a>
            <a href="{{ url('/#contact') }}" class="text-gray-200 hover:text-brand-gold transition">Contact</a>
        </nav>

        <div class="flex items-center space-x-5 lg:space-x-6">

            {{-- === FIX #1: WORKING SEARCH FORM === --}}
            {{-- This is now a mini-form that looks like an icon button --}}
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="query" placeholder="Search" class="w-full px-4 py-1.5 text-sm bg-white/10 border border-brand-gold/30 rounded-full text-gray-200 placeholder-gray-400
                              focus:outline-none focus:ring-1 focus:ring-brand-gold
                              md:w-32 md:focus:w-48 transition-all duration-300">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-300" />
                </button>
            </form>

            {{-- === FIX #2: TEXT/ICON COLORS === --}}

            {{-- Wishlist Icon --}}
            <a href="{{ route('wishlist.index') }}" class="text-gray-200 hover:text-brand-gold transition">
                <span class="sr-only">Wishlist</span>
                <x-heroicon-o-heart class="w-6 h-6" />
            </a>

            {{-- Cart Icon --}}
            <a href="{{ route('cart.index') }}" class="relative text-gray-200 hover:text-brand-gold transition">
                <span class="sr-only">Cart</span>
                <x-heroicon-o-shopping-bag class="w-6 h-6" />
                <span
                    class="absolute -top-2 -right-2 w-4 h-4 text-xs font-bold bg-brand-gold text-white rounded-full flex items-center justify-center">0</span>
            </a>

            {{-- Auth: Login/Profile Icon --}}
            @auth
                {{-- THIS IS THE WRAPPER YOU NEED --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">

                    {{-- This is the button that toggles the dropdown --}}
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-200 hover:text-brand-gold transition">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                class="w-8 h-8 rounded-full object-cover">
                        @else
                            <x-heroicon-o-user-circle class="w-8 h-8" />
                        @endif
                        <span class="font-medium hero-text hidden md:block">{{ Auth::user()->name }}</span>
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </button>

                    {{-- This is your dropdown. It will now be "absolute" relative to the wrapper --}}
                    <div x-show="open"
                        class="absolute right-0 mt-2 w-48 bg-[#0a2e2b] border border-[#d4af37]/30 rounded-lg shadow-lg py-2 z-50 text-gray-200"
                        style="display: none;" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95">

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-[#0d4837]">My
                            Profile</a>
                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm hover:bg-[#0d4837]">My
                            Orders</a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-[#0d4837]">Admin
                                Panel</a>
                        @endif
                        <hr class="border-gray-700 my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-[#0d4837]">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            @else
                {{-- Guest link... --}}
                <a href="{{ route('login') }}" class="text-gray-200 hover:text-brand-gold transition">
                    <span class="sr-only">Login</span>
                    <x-heroicon-o-user class="w-6 h-6" />
                </a>
            @endauth
        </div>
    </div>
</header>
