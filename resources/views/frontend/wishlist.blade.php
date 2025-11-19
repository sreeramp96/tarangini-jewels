@use('Illuminate\Support\Facades\Storage')
@extends('layouts.frontend')

@section('content')
<main class="bg-gray-100 py-16 px-6 lg:px-20 min-h-[60vh]">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800 mb-8 text-center">My Wishlist</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($wishlistedProducts as $product)
                {{-- Product Card (Same style as your category page) --}}
                <div class="bg-white rounded-lg shadow overflow-hidden group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : Storage::url($product->images->first()->image_path)) : asset('images/necklace.jpg') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-72 object-cover transition duration-500 ease-in-out group-hover:scale-105">
                        </div>
                    </a>

                    {{-- Product Info --}}
                    <div class="p-4 text-center">
                        <h4 class="text-md font-medium text-gray-800 truncate hero-text">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mt-1">
                            @if($product->discount_price)
                                <span class.="line-through text-gray-400">₹{{ number_format($product->price, 0) }}</span>
                                <span class.="font-semibold text-gray-800 ml-1">₹{{ number_format($product->discount_price, 0) }}</span>
                            @else
                                <span class.="font-semibold text-gray-800">₹{{ number_format($product->price, 0) }}</span>
                            @endif
                        </p>
                    </div>

                    {{-- Remove from Wishlist Form --}}
                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button typea="submit" class="bg-white p-1.5 rounded-full shadow text-red-500 hover:bg-red-50 transition" title="Remove from Wishlist">
                            <x-heroicon-s-heart class="w-5 h-5" /> {{-- Solid heart for "remove" --}}
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-lg text-gray-500 col-span-full text-center">Your wishlist is empty.</p>
            @endforelse
        </div>

        <div class="max-w-7xl mx-auto mt-12">
            {{ $wishlistedProducts->links() }}
        </div>
    </div>
</main>
@endsection
