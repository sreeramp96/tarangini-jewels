@extends('layouts.frontend')

@section('content')
    <main class="bg-[#0b3d2e] py-16 px-6 lg:px-20">
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold hero-text gold-gradient">
                {{ $category->name }}
            </h1>
            <p class="text-lg text-gray-300 leading-relaxed max-w-2xl mx-auto mt-4">
                {{ $category->description }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            @forelse($products as $product)
                <div
                    class="bg-[#0b3d2e]/70 border border-[#d4af37]/40 rounded-2xl overflow-hidden shadow-lg glow-hover transition p-2">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('storage/' . $product->images->first()->image_path)) : asset('images/necklace.jpg') }}"
                            class="w-full h-64 object-cover rounded-xl">
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
                    </a>
                </div>
            @empty
                <p class="text-lg text-gray-400 col-span-full text-center">No products found in this category.</p>
            @endforelse
        </div>

        <div class="max-w-7xl mx-auto mt-12">
            {{ $products->links() }}
        </div>
    </main>
@endsection