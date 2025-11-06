<header class="flex flex-col bg-[#0b3d2e]/90 backdrop-blur-md sticky top-0 z-50 shadow-md">

    <div class="flex justify-between items-center w-full px-6 lg:px-20 py-3">

        <a href="{{ url('/') }}" class="flex items-center space-x-2 flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Tarangini Jewels Logo"
                class="h-10 lg:h-12 w-auto object-contain">
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
            <a href="#" class="text-gray-200 hover:text-[#d4af37] transition">
                <span class="sr-only">Wishlist</span>
                <x-heroicon-o-heart class="w-6 h-6" />
            </a>

            <a href="{{ route('cart.index') }}" class="relative text-gray-200 hover:text-[#d4af37] transition">
                <span class="sr-only">Cart</span>
                <x-heroicon-o-shopping-bag class="w-6 h-6" />
                <span
                    class="absolute -top-2 -right-2 w-4 h-4 text-xs font-bold bg-[#d4af37] text-[#0b3d2e] rounded-full flex items-center justify-center">0</span>
            </a>

            @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-200 hover:text-[#d4af37] transition">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                class="w-8 h-8 rounded-full object-cover">
                        @else
                            <x-heroicon-o-user-circle class="w-8 h-8" />
                        @endif

                        <span class="font-medium hero-text">{{ Auth::user()->name }}</span>
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </button>

                    <div x-show="open"
                        class="absolute right-0 mt-2 w-48 bg-[#0a2e2b] border border-[#d4af37]/30 rounded-lg shadow-lg py-2 z-50"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" style="display: none;">

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-200 hover:bg-[#0d4837]">My Profile</a>

                        <a href="{{ route('orders.index') }}"
                            class="block px-4 py-2 text-sm text-gray-200 hover:bg-[#0d4837]">My Orders</a>

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-200 hover:bg-[#0d4837]">Admin Panel</a>
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
                <a href="{{ route('login') }}" class="text-gray-200 hover:text-[#d4af37] transition">
                    <x-heroicon-o-user class="w-6 h-6" />
                </a>
            @endauth
        </nav>
    </div>

    <nav class="w-full flex justify-center items-center py-3 bg-[#0a2e2b] border-y border-[#d4af37]/30">
        <div class="flex items-center space-x-6 lg:space-x-10 text-sm hero-text">
            @php
                $navLinkClasses = 'flex flex-col items-center text-gray-200 hover:text-[#d4af37] transition';
            @endphp

            <a href="#collections" class="{{ $navLinkClasses }}">
                <x-heroicon-o-sparkles class="w-6 h-6 mb-1" />
                <span>Collections</span>
            </a>
            <a href="#" class="{{ $navLinkClasses }}">
                <x-heroicon-o-viewfinder-circle class="w-6 h-6 mb-1" />
                <span>Rings</span>
            </a>
            <a href="#" class="{{ $navLinkClasses }}">
                <x-heroicon-o-star class="w-6 h-6 mb-1" />
                <span>Earrings</span>
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
