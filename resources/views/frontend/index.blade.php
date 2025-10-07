@extends('frontend.layouts.app')

@section('content')
    <section class="hero bg-gray-100 text-center py-10">
        <h1 class="text-4xl font-bold mb-2">Welcome to Tarangini Jewels</h1>
        <p class="text-gray-700">Discover the beauty of handcrafted jewelry</p>
    </section>

    <section class="products py-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Featured Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-6">
            @foreach ($featuredProducts as $product)
                <div class="border rounded-lg p-4 text-center">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover mb-3">
                    <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500">₹{{ $product->price }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
