<nav class="bg-green-900 shadow p-4 flex justify-between items-center">
    <!-- Logo + Site Name -->
    <a href="{{ route('home') }}" class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" alt="Tarangini Jewels" class="h-10 w-10 object-contain">
        <span class="text-2xl font-bold text-yellow-500">Tarangini Jewels</span>
    </a>

    <!-- Menu -->
    <ul class="flex space-x-6 text-yellow-200">
        <li><a href="{{ route('shop') }}" class="hover:text-yellow-400">Shop</a></li>
        <li><a href="{{ route('offers') }}" class="hover:text-yellow-400">Offers</a></li>
        <li><a href="{{ route('testimonials') }}" class="hover:text-yellow-400">Testimonials</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-yellow-400">Contact</a></li>
    </ul>
</nav>
