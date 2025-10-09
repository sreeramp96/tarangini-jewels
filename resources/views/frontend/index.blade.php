@extends('frontend.layouts.app')

@section('content')
    <section class="text-center py-16 bg-amber-50">
        <h1 class="text-4xl font-bold text-amber-700 mb-4">Welcome to Tarangini Jewels</h1>
        <p class="text-gray-600 mb-8">Discover elegant designs crafted with passion and tradition.</p>
        <a href="{{ route('shop') }}" class="bg-amber-600 text-white px-6 py-3 rounded hover:bg-amber-700">Shop Now</a>
    </section>

    <section class="max-w-6xl mx-auto py-12">
        <h2 class="text-2xl font-bold mb-6 text-center">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($featuredProducts as $product)
                @php
                    $mainImage = $product->images()->where('is_primary', 1)->first();
                    $imageUrl = $mainImage ? asset('storage/' . $mainImage->image_path) : '/placeholder.jpg';
                @endphp
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <img src="{{ $imageUrl }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-2">₹{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('product.show', $product->slug) }}"
                            class="text-amber-600 font-medium hover:underline">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-gray-50 py-12">
        <h2 class="text-2xl font-bold text-center mb-6">Latest Offers</h2>
        <div class="max-w-4xl mx-auto grid sm:grid-cols-2 gap-6">
            @forelse($offers as $offer)
                <div class="bg-white shadow p-6 rounded-lg text-center">
                    <h3 class="font-bold text-amber-700">{{ $offer->name }}</h3>

                    {{-- --- CRITICAL FIX: DYNAMIC OFFER TYPE --- --}}
                    <p class="text-gray-600 mt-2">
                        {{ $offer->type === 'percentage' ? $offer->value . '% OFF' : '₹' . number_format($offer->value, 0) . ' OFF' }}
                    </p>
                    {{-- --- END CRITICAL FIX --- --}}

                    <p class="text-sm text-gray-500 mt-1">Valid till {{ $offer->end_date->format('M d, Y') }}</p>
                </div>
            @empty
                <p class="text-center text-gray-500">No current offers available.</p>
            @endforelse
        </div>
    </section>

    <section class="max-w-5xl mx-auto py-12 text-center">
        <h2 class="text-2xl font-bold mb-6">Customer Testimonials</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($testimonials as $t)
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <p class="italic text-gray-700 mb-3">"{{ $t->message }}"</p>
                    <h4 class="font-semibold text-amber-700">{{ $t->name }}</h4>
                </div>
            @endforeach
        </div>
    </section>
@endsection
