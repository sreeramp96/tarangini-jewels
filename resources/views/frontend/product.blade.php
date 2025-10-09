@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8">
            <img src="{{ $product->image }}" class="rounded-lg shadow">
            <div>
                <h2 class="text-3xl font-semibold text-amber-700">{{ $product->name }}</h2>
                <p class="text-gray-600 my-4">{{ $product->description }}</p>
                <p class="text-2xl font-bold text-amber-700 mb-4">₹{{ number_format($product->price) }}</p>
                <button class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700">Add to Cart</button>
            </div>
        </div>
    </div>
@endsection
