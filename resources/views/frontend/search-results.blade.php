@extends('layouts.frontend')

@section('content')
<main class="bg-white py-16 px-6 lg:px-20 min-h-[60vh]">
    <div class="text-center mb-12">
        <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800">
            Search Results
        </h1>
        <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto mt-4">
            Showing results for: "<span class="font-semibold text-gray-900">{{ $query }}</span>
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
        @forelse($products as $product)
            {{-- Product Card (Same as your category page) --}}
            <div class="bg-white rounded-lg shadow overflow-hidden group relative">
                 <a href="{{ route('products.show', $product->slug) }}" class="block">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('images/products/' . $product->images->first()->image_path)) : asset('images/necklace.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-72 object-cover transition duration-500 ease-in-out group-hover:scale-105">

                        {{-- Badges --}}
                         <div class="absolute top-2 left-2 flex flex-col space-y-1">
                             @if($product->discount_price && $product->price > 0)
                                 @php $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                                 <span class="bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">{{ $discountPercent }}% OFF</span>
                             @endif
                             @if($product->stock <= 0)
                                 <span class="bg-gray-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">Out of stock</span>
                             @endif
                         </div>

                        {{-- Wishlist Form --}}
                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                            @csrf
                            <button type="submit" class="bg-white p-1.5 rounded-full shadow text-gray-400 hover:text-red-500 transition" title="Add to Wishlist">
                                <x-heroicon-o-heart class="w-5 h-5" />
                            </button>
                        </form>
                    </div>

                    {{-- Product Info --}}
                    <div class="p-4 text-center">
                        <h4 class="text-md font-medium text-gray-800 truncate hero-text">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-sm mt-1">
                            @if($product->discount_price)
                                <span class="line-through text-gray-400">₹{{ number_format($product->price, 0) }}</span>
                                <span class="font-semibold text-gray-800 ml-1">₹{{ number_format($product->discount_price, 0) }}</span>
                            @else
                                <span class="font-semibold text-gray-800">₹{{ number_format($product->price, 0) }}</span>
                            @endif
                        </p>
                    </div>
                </a>

                {{-- "Add to Cart" Form --}}
                <div class="px-4 pb-4">
                    <form action="{{ route('cart.store', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full btn-dark px-4 py-2 text-sm rounded glow-hover">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-lg text-gray-500 col-span-full text-center">Sorry, no products matched your search for "<span class="font-semibold">{{ $query }}</span>".</p>
        @endforelse
    </div>

    <div class="max-w-7xl mx-auto mt-12">
        {{-- This adds links to other pages if there are many results --}}
        {{ $products->appends(['query' => $query])->links() }}
    </div>
</main>
@endsection
