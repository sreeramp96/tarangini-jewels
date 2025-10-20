<header
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
</header>