@extends('layouts.frontend')

{{-- Use Alpine.js for a simple image gallery --}}
@section('content')
    <main class="bg-[#0b3d2e] text-gray-200 py-16 px-6 lg:px-20">
        <div x-data="{primaryImage: '{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('storage/' . $product->images->first()->image_path)) : asset('images/necklace.jpg') }}',
                images: [
                    @foreach($product->images as $image)
                        '{{ Str::startsWith($image->image_path, 'http') ? $image->image_path : asset('storage/' . $image->image_path) }}',
                    @endforeach
                ]}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-7xl mx-auto">
                <div>
                    <div class="border border-[#d4af37]/40 rounded-2xl p-2 mb-4">
                        <img :src="primaryImage" alt="{{ $product->name }}"
                            class="w-full h-[500px] object-cover rounded-xl">
                    </div>

                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        <template x-for="image in images" :key="image">
                            <button @click="primaryImage = image"
                                class="flex-shrink-0 w-24 h-24 border-2 rounded-lg p-1 transition :class="
                                primaryImage===image ? 'border-[#d4af37]'
                                : 'border-transparent opacity-60 hover:opacity-100'"> <img :src=" image" alt="Thumbnail"
                                class="w-full h-full object-cover rounded-md">
                            </button>
                        </template>
                    </div>
                </div>

                <div class="py-8">
                    <span class="text-sm text-gray-400 hero-text">{{ $product->category->name }}</span>
                    <h1 class="text-4xl lg:text-5xl font-bold hero-text gold-gradient my-4">
                        {{ $product->name }}
                    </h1>

                    <div class="my-6">
                        @if($product->discount_price)
                            <span class="line-through text-2xl text-gray-500">₹{{ number_format($product->price, 2) }}</span>
                            <span
                                class="font-bold text-4xl text-white ml-3">₹{{ number_format($product->discount_price, 2) }}</span>
                        @else
                            <span class="font-bold text-4xl text-white">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <p class="text-lg text-gray-300 leading-relaxed mb-8">
                        {{ $product->description }}
                    </p>

                    <div class="flex items-center space-x-4">
                        <button class="flex-grow btn-gold px-8 py-4 rounded font-medium text-lg">
                            Add to Cart
                        </button>
                        <button class="p-4 border border-[#d4af37]/40 rounded glow-hover">
                            <x-heroicon-o-heart class="w-6 h-6 text-[#d4af37]" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <section class="max-w-7xl mx-auto mt-20">
            <h3 class="text-3xl font-semibold gold-gradient mb-8 hero-text">You May Also Like</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $relatedProduct)
                    <div
                        class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}">
                            <img src="{{ $relatedProduct->images->isNotEmpty() ? (Str::startsWith($relatedProduct->images->first()->image_path, 'http') ? $relatedProduct->images->first()->image_path : asset('storage/' . $relatedProduct->images->first()->image_path)) : asset('images/necklace.jpg') }}"
                                alt="{{ $relatedProduct->name }}" class="w-full h-64 object-cover rounded-xl">
                            <div class="p-5 hero-text">
                                <h4 class="text-xl font-medium text-[#d4af37] truncate">{{ $relatedProduct->name }}</h4>
                                <p class="text-gray-300 text-sm mt-2">
                                    @if($relatedProduct->discount_price)
                                        <span
                                            class="line-through text-gray-500">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                        <span
                                            class="font-bold text-lg text-white ml-2">₹{{ number_format($relatedProduct->discount_price, 2) }}</span>
                                    @else
                                        <span
                                            class="font-bold text-lg text-white">₹{{ number_format($relatedProduct->price, 2) }}</span>
                                    @endif
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection