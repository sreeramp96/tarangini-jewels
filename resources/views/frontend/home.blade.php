@use('Illuminate\Support\Facades\Storage')
@extends('layouts.frontend')
{{-- @php $media = $product->getFirstMedia('images'); @endphp --}}
@section('content')

    <section class="relative flex items-center justify-start px-6 lg:px-20 min-h-[70vh] lg:min-h-[80vh] overflow-hidden">
        <div class="absolute inset-0 z-0" x-data="{
                 activeSlide: 0,
                 slides: {{ $heroCarouselProducts->count() }},
                 autoplay: null,
                 startAutoplay() {
                    this.autoplay = setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides }, 5000)
                 },
                 stopAutoplay() { clearInterval(this.autoplay) }
             }" x-init="startAutoplay()">

            <div class="relative w-full h-full">
                @foreach($heroCarouselProducts as $index => $heroProduct)
                    <div x-show="activeSlide === {{ $index }}"
                        class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="opacity-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <img src="{{ $heroProduct->primary_image_url }}" alt="{{ $heroProduct->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                @endforeach
            </div>
        </div>

<div class="relative z-10 lg:w-1/2 max-w-xl text-white drop-shadow-text-readable px-4">
        <h2 class="text-4xl lg:text-6xl font-bold hero-text mb-6 leading-tight">
            <span class="text-text-gold-gradient">Elegance Redefined</span><br>in Every Jewel
        </h2>
        <p class="text-lg text-gray-100 mb-8 leading-relaxed font-medium">
            Discover handcrafted luxury with a touch of divine grace. Every piece at
            <span class="text-brand-gold font-bold">Tarangini</span>
                embodies timeless beauty and artistry.
        </p>

        <a href="#featured-products" class="btn-gold px-8 py-3 rounded font-semibold text-lg inline-block border-2 border-transparent hover:border-white">
            Explore Collection
        </a>
        </div>

    </section>

    <section id="categories" class="bg-gray-100 px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gray-800 mb-12 hero-text">
            Shop by Category
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group">
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out group-hover:shadow-xl">
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            @if($category->image)
                            <img src="{{Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                            <x-heroicon-o-sparkles class="w-16 h-16 text-gray-400" />
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h4 class="text-lg font-medium text-gray-800 group-hover:text-brand-gold transition hero-text">
                                {{ $category->name }}
                            </h4>
                            <span class="text-sm text-gray-500 group-hover:text-brand-gold transition">Explore All</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section id="featured-products" class="bg-white px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gray-800 mb-12 hero-text">
            New Arrivals
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow overflow-hidden group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->primary_image_url }}"
                                alt="{{ $product->name }}"
                                class="w-full h-72 object-cover transition duration-500 ease-in-out group-hover:scale-105">
                            <div class="absolute top-2 left-2 flex flex-col space-y-1">
                                @if($product->discount_price && $product->price > 0)
                                    @php
                                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                     @endphp
                                    <span
                                        class="bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">{{ $discountPercent }}%
                                        OFF</span>
                                @endif
                                @if($product->stock <= 0)
                                    <span class="bg-gray-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">Out of
                                        stock</span>
                                @endif
                            </div>
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                class="absolute top-2 right-2 z-10">
                                @csrf
                                <button type="submit"
                                    class="bg-white p-1.5 rounded-full shadow text-gray-400 hover:text-red-500 transition"
                                    title="Add to Wishlist">
                                    <x-heroicon-o-heart class="w-5 h-5" />
                                </button>
                            </form>
                        </div>

                        <div class="p-4 text-center">
                            <h4 class="text-md font-medium text-gray-800 truncate hero-text">{{ $product->name }}</h4>
                            <div class="flex justify-center mt-2">
                                 <x-star-rating :rating="$product->reviews_avg_rating" :count="$product->reviews_count" />
                            </div>
                            <p class="text-gray-600 text-sm mt-1">
                                @if($product->discount_price)
                                    <span class="line-through text-gray-400">₹{{ number_format($product->price, 0) }}</span>
                                    <span
                                        class="font-semibold text-gray-800 ml-1">₹{{ number_format($product->discount_price, 0) }}</span>
                                @else
                                    <span class="font-semibold text-gray-800">₹{{ number_format($product->price, 0) }}</span>
                                @endif
                            </p>
                            <button class="mt-3 w-full btn-dark px-4 py-2 text-sm rounded btn-gold glow-hover">Add to
                                Cart</button>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-lg text-gray-500 col-span-full text-center">No featured products available.</p>
            @endforelse
        </div>
    </section>

    <section id="testimonials" class="bg-[#0b3d2e] px-6 lg:px-20 py-20">
    <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gold-gradient mb-12 hero-text">
            Words of Radiance
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($reviews as $review)
            <div class="relative flex flex-col bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl p-8 text-center glow-hover transition h-full">
                <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-[#d4af37]/10" />
                <p class="text-gray-300 leading-loose mb-6 z-10 relative flex-grow">
                    "{{ Str::limit($review->comment, 150) }}"
                </p>
                <div class="flex justify-center items-center space-x-1 mb-4">
                    @foreach(range(1, 5) as $i)
                        @if($i <= $review->rating)
                    <x-heroicon-s-star class="w-5 h-5 text-[#d4af37]" />
                        @else
                            <x-heroicon-s-star class="w-5 h-5 text-gray-600" />
                        @endif
                    @endforeach
                </div>
                <h4 class="font-semibold hero-text text-[#d4af37] text-lg">
                    {{ $review->user->name ?? 'Guest Customer' }}
                </h4>
                <p class="text-gray-400 text-sm mt-1">
                    Verified Buyer
                </p>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-400 py-10">
                <p>Be the first to share your radiance!</p>
            </div>
        @endforelse
        </div>
    </section>

    <section id="about" class="bg-[#0b3d2e] px-6 lg:px-20 py-20 text-center hero-text">
        <h3 class="text-3xl lg:text-4xl font-semibold text-gold-gradient mb-6">About Tarangini</h3>
        <p class="max-w-2xl mx-auto text-gray-300 leading-relaxed">
            At Tarangini Jewels, we blend ancient craftsmanship with modern elegance.
            Every piece narrates a story — inspired by Indian heritage, shaped with care, and perfected to shine for
            generations.
        </p>
    </section>

@endsection
