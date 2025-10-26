@extends('layouts.frontend')

@section('content')

    <section
        class="flex flex-col lg:flex-row items-center justify-between px-6 lg:px-20 py-16 lg:py-24 bg-[#0b3d2e] relative overflow-hidden hero-text">
        @if($heroProduct && $heroProduct->images->isNotEmpty())
            <div class="lg:w-1/2 max-w-xl mb-10 lg:mb-0 z-10">
                <h2 class="text-4xl lg:text-6xl font-bold hero-text gold-gradient mb-6 leading-tight">
                    {{ $heroProduct->name }}
                </h2>
                <p class="text-lg text-gray-200 mb-8 leading-relaxed">
                    {{ Str::limit($heroProduct->description, 150) }}
                </p>
                <a href="{{ route('products.show', $heroProduct->slug) }}" class="btn-gold px-6 py-3 rounded font-medium">
                    View Details
                </a>
            </div>

            <div class="relative z-10 lg:w-1/2 flex items-center justify-center lg:justify-end">
                <a href="{{ route('products.show', $heroProduct->slug) }}">
                    <img src="{{ $heroProduct->images->isNotEmpty() ? (Str::startsWith($heroProduct->images->first()->image_path, 'http') ? $heroProduct->images->first()->image_path : asset('storage/' . $heroProduct->images->first()->image_path)) : asset('images/hero.jpg') }}"
                        alt="{{ $heroProduct->name }}"
                        class="rounded-2xl glow-hover shadow-2xl w-full h-auto max-h-[550px] object-contain transition duration-500">
                </a>
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-[#d4af37]/20 rounded-full blur-3xl"></div>
            </div>

        @else
            <div class="lg:w-1/2 max-w-xl mb-10 lg:mb-0 z-10">
                <h2 class="text-4xl lg:text-6xl font-bold hero-text gold-gradient mb-6">
                    Elegance Redefined<br>in Every Jewel
                </h2>
                <p class="text-lg text-gray-200 mb-8 leading-relaxed">
                    Discover handcrafted luxury with a touch of divine grace. Every piece at <span
                        class="text-[#d4af37]">Tarangini</span>
                    embodies timeless beauty and artistry.
                </p>
            </div>
            <div class="relative z-10 lg:w-1/2 flex items-center justify-center lg:justify-end">
                <img src="{{ asset('images/hero.jpg') }}" alt="Elegant Jewelry Piece"
                    class="rounded-2xl glow-hover shadow-2xl w-full h-auto max-h-[550px] object-contain transition duration-500">
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-[#d4af37]/20 rounded-full blur-3xl"></div>
            </div>
        @endif

        <div class="absolute top-10 left-10 w-4 h-4 bg-[#d4af37]/40 rounded-full blur-sm animate-pulse"></div>
        <div class="absolute bottom-20 right-16 w-6 h-6 bg-[#d4af37]/40 rounded-full blur-md animate-ping"></div>
    </section>

    <section id="categories" class="bg-[#0d4837] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text">
            Shop by Category
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="text-center group">
                    <div
                        class="w-full h-32 md:h-40 bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl flex items-center justify-center p-4 glow-hover transition">
                        <x-heroicon-o-sparkles class="w-16 h-16 text-[#d4af37] group-hover:scale-110 transition-transform" />
                    </div>
                    <h4 class="mt-4 text-lg font-medium text-gray-200 group-hover:text-[#d4af37] transition hero-text">
                        {{ $category->name }}
                    </h4>
                </a>
            @endforeach
        </div>
    </section>


    <section id="featured-products" class="bg-[#0b3d2e] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text">
            Our Signature Collection
        </h3>

        <div class="flex space-x-8 overflow-x-auto pb-6">
            @forelse($featuredProducts as $product)
                <div class="flex-shrink-0 w-80">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div
                            class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2">
                            @if($product->images->isNotEmpty())
                                <img src="{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('storage/' . $product->images->first()->image_path)) : asset('images/necklace.jpg') }}"
                                    alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-xl">
                            @else
                                <img src="{{ asset('images/necklace.jpg') }}" alt="Placeholder"
                                    class="w-full h-64 object-cover rounded-xl">
                            @endif

                            <div class="p-5 hero-text">
                                <h4 class="text-xl font-medium text-[#d4af37] truncate">{{ $product->name }}</h4>
                                <p class="text-gray-300 text-sm mt-2">
                                    @if($product->discount_price)
                                        <span class="line-through text-gray-500">₹{{ number_format($product->price, 2) }}</span>
                                        <span
                                            class="font-bold text-lg text-white ml-2">₹{{ number_format($product->discount_price, 2) }}</span>
                                    @else
                                        <span class="font-bold text-lg text-white">₹{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-lg text-gray-400 text-center w-full">No featured products available at this time.</p>
            @endforelse
        </div>
    </section>

    <section id="testimonials" class="bg-[#0b3d2e] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center gold-gradient mb-12 hero-text">
            Words of Radiance
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "The craftsmanship is breathtaking. My necklace is more than jewelry; it's a piece of art that I will
                    cherish forever. The attention to detail is simply unparalleled."
                </p>

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
            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "I ordered a ring for our anniversary, and the service was as brilliant as the diamond itself. From
                    selection to delivery, the experience was seamless and personal."
                </p>
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

            <div
                class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />

                <p class="text-gray-300 italic leading-loose mb-6 z-10 relative flex-grow">
                    "Tarangini Jewels transformed a family heirloom into a modern masterpiece. They respected the
                    sentiment while infusing new life into the design. Truly exceptional artists."
                </p>

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