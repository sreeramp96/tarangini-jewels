@extends('layouts.frontend')

@section('content')

    <section
        class="flex flex-col lg:flex-row items-center justify-between px-6 lg:px-20 py-16 lg:py-24 bg-[#0b3d2e] relative overflow-hidden hero-text">
        <div class="lg:w-1/2 max-w-xl mb-10 lg:mb-0 z-10">
            <h2 class="text-4xl lg:text-6xl font-bold hero-text gold-gradient mb-6">
                Elegance Redefined<br>in Every Jewel
            </h2>
            <p class="text-lg text-gray-200 mb-8 leading-relaxed">
                Discover handcrafted luxury with a touch of divine grace. Every piece at <span
                    class="text-[#d4af37]">Tarangini</span>
                embodies timeless beauty and artistry.
            </p>
            <a href="#collections" class="btn-gold px-6 py-3 rounded font-medium">Explore Collection</a>
        </div>

        <div class="relative z-10 lg:w-1/2 flex items-center justify-center lg:justify-end">
            <img src="{{ asset('storage/Images/hero.jpg') }}" alt="Elegant Jewelry Piece"
                class="rounded-2xl glow-hover shadow-2xl h-auto max-h-[550px] object-contain transition duration-500">

            <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-[#d4af37]/20 rounded-full blur-3xl"></div>
        </div>

        <div class="absolute top-10 left-10 w-4 h-4 bg-[#d4af37]/40 rounded-full blur-sm animate-pulse"></div>
        <div class="absolute bottom-20 right-16 w-6 h-6 bg-[#d4af37]/40 rounded-full blur-md animate-ping"></div>
    </section>

    <section id="collections" class="bg-[#0d4837] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text ">Our Signature Collection
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2">
                <img src="{{ asset('storage/Images/necklace.jpg') }}" alt="Necklace"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5 hero-text ">
                    <h4 class="text-xl font-medium text-[#d4af37]">Emerald Grace Necklace</h4>
                    <p class="text-gray-300 text-sm mt-2">A masterpiece of balance between regal tradition and modern
                        allure.</p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/ring.jpg') }}" alt="Ring" class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">Golden Mirage Ring</h4>
                    <p class="text-gray-300 text-sm mt-2">Intricately crafted to catch the light and hearts alike.</p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/earrings.jpg') }}" alt="Earrings"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">Chandrika Earrings</h4>
                    <p class="text-gray-300 text-sm mt-2">Inspired by celestial charm — elegance for every celebration.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="collections" class="bg-[#0d4837] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text ">Shop by Category
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2">
                <img src="{{ asset('storage/Images/necklace.jpg') }}" alt="Necklace"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5 hero-text ">
                    <h4 class="text-xl font-medium text-[#d4af37]">EARRINGS</h4>
                    <p class="text-gray-300 text-sm mt-2">A masterpiece of balance between regal tradition and modern
                        allure.</p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/ring.jpg') }}" alt="Ring" class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">FINGER RINGS</h4>
                    <p class="text-gray-300 text-sm mt-2">Intricately crafted to catch the light and hearts alike.</p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/earrings.jpg') }}" alt="Earrings"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">PENDANTS</h4>
                    <p class="text-gray-300 text-sm mt-2">Inspired by celestial charm — elegance for every celebration.
                    </p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/earrings.jpg') }}" alt="Earrings"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">BRACELETS</h4>
                    <p class="text-gray-300 text-sm mt-2">Inspired by celestial charm — elegance for every celebration.
                    </p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/earrings.jpg') }}" alt="Earrings"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">BANGLES</h4>
                    <p class="text-gray-300 text-sm mt-2">Inspired by celestial charm — elegance for every celebration.
                    </p>
                </div>
            </div>
            <div
                class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2 hero-text ">
                <img src="{{ asset('storage/Images/earrings.jpg') }}" alt="Earrings"
                    class="w-full h-64 object-cover rounded-xl">
                <div class="p-5">
                    <h4 class="text-xl font-medium text-[#d4af37]">CHAINS</h4>
                    <p class="text-gray-300 text-sm mt-2">Inspired by celestial charm — elegance for every celebration.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="bg-[#0b3d2e] px-6 lg:px-20 py-20">
        {{-- Section Heading --}}
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text">
            Words of Radiance
        </h3>

        {{-- Grid container for the testimonial cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- Testimonial Card 1 --}}
            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "The craftsmanship is breathtaking. My necklace is more than jewelry; it's a piece of art that I will
                    cherish forever. The attention to detail is simply unparalleled."
                </p>

                {{-- NEW: Star Rating --}}
                <div class="flex justify-center items-center space-x-1 mb-4">
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                </div>

                <h4 class="font-semibold hero-text text-[#d4af37] text-lg">
                    Priya Sharma
                </h4>
                <p class="text-gray-400 text-sm mt-1">
                    Mumbai, Maharashtra
                </p>
            </div>

            {{-- Testimonial Card 2 --}}
            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "I ordered a ring for our anniversary, and the service was as brilliant as the diamond itself. From
                    selection to delivery, the experience was seamless and personal."
                </p>

                {{-- NEW: Star Rating --}}
                <div class="flex justify-center items-center space-x-1 mb-4">
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                </div>

                <h4 class="font-semibold hero-text text-[#d4af37] text-lg">
                    Arjun Nair
                </h4>
                <p class="text-gray-400 text-sm mt-1">
                    Bengaluru, Karnataka
                </p>
            </div>

            {{-- Testimonial Card 3 --}}
            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "Tarangini Jewels transformed a family heirloom into a modern masterpiece. They respected the
                    sentiment while infusing new life into the design. Truly exceptional artists."
                </p>

                {{-- NEW: Star Rating --}}
                <div class="flex justify-center items-center space-x-1 mb-4">
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                </div>

                <h4 class="font-semibold hero-text text-[#d4af37] text-lg">
                    Ananya Reddy
                </h4>
                <p class="text-gray-400 text-sm mt-1">
                    Hyderabad, Telangana
                </p>
            </div>

        </div>
    </section>

    <section id="about" class="bg-[#0b3d2e] px-6 lg:px-20 py-20 text-center hero-text">
        <h3 class="text-3xl lg:text-4xl font-semibold gold-gradient mb-6">About Tarangini</h3>
        <p class="max-w-2xl mx-auto text-gray-300 leading-relaxed">
            At Tarangini Jewels, we blend ancient craftsmanship with modern elegance.
            Every piece narrates a story — inspired by Indian heritage, shaped with care, and perfected to shine for
            generations.
        </p>
    </section>

@endsection