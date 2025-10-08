@extends('frontend.layouts.app')

@section('content')
    <section class="max-w-6xl mx-auto py-12">
        <h2 class="text-3xl font-bold mb-6 text-center">Our Collection</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <img src="{{ $product->image ?? '/placeholder.jpg' }}" class="w-full h-48 object-cover"
                        alt="{{ $product->name }}">
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
@endsection
