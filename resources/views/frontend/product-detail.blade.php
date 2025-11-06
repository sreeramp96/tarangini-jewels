@extends('layouts.frontend')

{{-- Use Alpine.js for a simple image gallery --}}
@section('content')
    <main class="bg-[#0b3d2e] text-gray-200 py-16 px-6 lg:px-20">
        <div x-data="{primaryImage: '{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('images/products/' . $product->images->first()->image_path)) : asset('images/necklace.jpg') }}',
                    images: [
                        @foreach($product->images as $image)
                            '{{ Str::startsWith($image->image_path, 'http') ? $image->image_path : asset('images/products/' . $image->image_path) }}',
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
                        <form action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-8">
                            @csrf
                            <div class="flex items-center space-x-4">
                                {{-- Quantity Input (Optional but good) --}}
                                <div class="w-24">
                                    <label for="quantity" class="sr-only">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stock }}"
                                        class="w-full px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-gold focus:border-brand-gold text-gray-800 text-center">
                                </div>

                                {{-- Add to Cart Button --}}
                                <button type="submit" class="flex-grow btn-gold px-8 py-4 rounded font-semibold text-lg"
                                    {{-- Disable button if out of stock --}} @if($product->stock <= 0) disabled @endif>
                                    {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                </button>

                                {{-- Wishlist Button --}}
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST"
                                class="absolute top-2 right-2 z-10">
                                @csrf
                                <button type="submit"
                                    class="bg-white p-1.5 rounded-full shadow text-gray-400 hover:text-red-500 transition"
                                    title="Add to Wishlist">
                                    <x-heroicon-o-heart class="w-5 h-5" /> {{-- Outline heart for "add" --}}
                                </button>
                            </form>
                            </div>
                            @if($product->stock <= 0)
                                <p class="text-red-500 text-sm mt-2">This product is currently out of stock.</p>
                            @elseif($product->stock < 10) {{-- Optional: Show low stock warning --}}
                                <p class="text-yellow-500 text-sm mt-2">Only {{ $product->stock }} left in stock!</p>
                            @endif
                        </form>
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
                            <img src="{{ $relatedProduct->images->isNotEmpty() ? (Str::startsWith($relatedProduct->images->first()->image_path, 'http') ? $relatedProduct->images->first()->image_path : asset('images/products/' . $relatedProduct->images->first()->image_path)) : asset('images/necklace.jpg') }}"
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
