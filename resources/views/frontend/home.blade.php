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
                        <img src="{{ $heroProduct->primary_image_url }}" alt="{{ $heroProduct->name }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10 lg:w-1/2 max-w-xl text-white drop-shadow-text-readable px-4">
            <h2 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight site-font">
                <span class="text-text-gold-gradient">Elegance Redefined</span><br>in Every Jewel
            </h2>
            <p class="text-lg text-gray-100 mb-8 leading-relaxed font-medium site-font">
                Discover handcrafted luxury with a touch of divine grace. Every piece at
                <span class="text-brand-gold font-bold site-font">Tarangini</span>
                embodies timeless beauty and artistry.
            </p>

            <a href="#featured-products"
                class="btn-gold px-8 py-3 rounded-sm font-semibold text-lg inline-block border-2 border-transparent hover:border-white site-font">
                Explore Collection
            </a>
        </div>

    </section>

    <section id="categories" class="bg-gray-100 px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gray-800 mb-12 site-font">
            Shop by Category
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group">
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out group-hover:shadow-xl">
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            @if($category->image)
                                <img src="{{Storage::url($category->image) }}" alt="{{ $category->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <x-heroicon-o-sparkles class="w-16 h-16 text-gray-400" />
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h4 class="text-lg font-medium text-gray-800 group-hover:text-brand-gold transition">
                                {{ $category->name }}
                            </h4>
                            <span class="text-sm text-gray-500 group-hover:text-brand-gold transition site-font">Explore All</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section id="featured-products" class="bg-white px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gray-800 mb-12 site-font">
            New Arrivals
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="text-lg text-gray-500 col-span-full text-center">
                    No featured products available.
                </p>
            @endforelse
        </div>
    </section>

    <section id="testimonials" class="bg-[#0b3d2e] px-6 lg:px-20 py-20">
        <h3 class="text-3xl lg:text-4xl font-semibold text-center text-gold-gradient mb-12 site-font">
            Words of Radiance
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($reviews as $review)
                <div
                    class="relative flex flex-col bg-[#0b3d2e]/70 border border-brand-gold/40 rounded-2xl p-8 text-center glow-hover transition h-full">
                    <x-heroicon-s-chat-bubble-left-right class="absolute top-4 left-4 w-12 h-12 text-brand-gold/10" />
                    <p class="text-gray-300 leading-loose mb-6 z-10 relative grow">
                        "{{ Str::limit($review->comment, 150) }}"
                    </p>
                    <div class="flex justify-center items-center space-x-1 mb-4">
                        @foreach(range(1, 5) as $i)
                            @if($i <= $review->rating)
                                <x-heroicon-s-star class="w-5 h-5 text-brand-gold" />
                            @else
                                <x-heroicon-s-star class="w-5 h-5 text-gray-600" />
                            @endif
                        @endforeach
                    </div>
                    <h4 class="font-semibold hero-text text-brand-gold text-lg">
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

    <section id="about" class="bg-[#0b3d2e] px-6 lg:px-20 py-20 text-center site-font">
        <h3 class="text-3xl lg:text-4xl font-semibold text-gold-gradient mb-6">About Tarangini</h3>
        <p class="max-w-2xl mx-auto text-gray-300 leading-relaxed">
            At Tarangini Jewels, we blend ancient craftsmanship with modern elegance.
            Every piece narrates a story — inspired by Indian heritage, shaped with care, and perfected to shine for
            generations.
        </p>
    </section>

@endsection
