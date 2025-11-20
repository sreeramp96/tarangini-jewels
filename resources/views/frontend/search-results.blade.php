@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')
@extends('layouts.frontend')

@section('content')
    <main class="bg-white py-12 px-4 lg:px-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800">Search Results</h1>
            <p class="text-lg text-gray-600 mt-4">
                Found {{ $products->total() }} results for "<span class="font-semibold text-gray-900">{{ $queryTerm }}</span>"
            </p>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <aside class="lg:col-span-1">
                    @include('frontend.partials.product-filters')
                </aside>

                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-lg shadow overflow-hidden group relative border border-gray-100">
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <div class="relative overflow-hidden">
                                        <img src="{{ $product->primary_image_url }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-64 object-cover transition duration-500 ease-in-out group-hover:scale-105">

                                        <div class="absolute top-2 left-2 flex flex-col space-y-1">
                                            @if($product->discount_price)
                                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase">Sale</span>
                                            @endif
                                            @if($product->stock <= 0)
                                                <span class="bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded uppercase">Sold Out</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                                    @csrf
                                    <button type="submit" class="bg-white p-1.5 rounded-full shadow text-gray-400 hover:text-red-500 transition" title="Add to Wishlist">
                                        <x-heroicon-o-heart class="w-5 h-5" />
                                    </button>
                                </form>

                                <div class="p-4 text-center">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                                        <h4 class="text-md font-medium text-gray-800 truncate hero-text">{{ $product->name }}</h4>

                                        <div class="flex justify-center mt-2">
                                            <x-star-rating :rating="$product->reviews_avg_rating" :count="$product->reviews_count" />
                                        </div>

                                        <p class="text-gray-600 text-sm mt-1 font-bold">
                                            @if($product->discount_price)
                                                <span class="line-through text-gray-400 font-normal text-xs mr-1">₹{{ number_format($product->price, 0) }}</span>
                                                ₹{{ number_format($product->discount_price, 0) }}
                                            @else
                                                ₹{{ number_format($product->price, 0) }}
                                            @endif
                                        </p>
                                    </a>

                                    <form x-data="addToCartForm" @submit.prevent="submit" action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-3">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full btn-dark px-4 py-2 text-sm rounded glow-hover flex justify-center items-center"
                                                :disabled="loading || {{ $product->stock <= 0 ? 'true' : 'false' }}"
                                                :class="{ 'opacity-75 cursor-not-allowed': loading }">
                                            <span x-show="!loading">{{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}</span>
                                            <svg x-show="loading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <x-heroicon-o-magnifying-glass class="w-12 h-12 text-gray-300 mx-auto mb-3"/>
                                <p class="text-gray-500 text-lg">We couldn't find anything for "<span class="font-semibold">{{ $queryTerm }}</span>".</p>
                                <p class="text-gray-400 text-sm mt-1">Try checking your spelling or using more general terms.</p>
                                <a href="{{ route('home') }}" class="text-brand-gold hover:underline mt-4 inline-block">Back to Home</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $products->appends(['query' => $queryTerm])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
