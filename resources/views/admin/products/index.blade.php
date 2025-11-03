@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-semibold text-gray-200 hero-text">Products</h1>
        <a href="{{ route('admin.products.create') }}"
            class="px-6 py-2 rounded text-white font-medium btn-gold glow-hover whitespace-nowrap">
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-800/50 border border-green-600 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.products.index') }}">
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <input type="text" name="search" placeholder="Search products by name..." value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-600 bg-[#0a2e2b] text-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-500 placeholder-gray-500">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </div>
            </div>

            <div class="relative">
                <select name="category_id"
                    class="appearance-none w-full md:w-48 pl-4 pr-10 py-2 border border-gray-600 bg-[#0a2e2b] text-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <x-heroicon-s-chevron-down class="w-5 h-5" />
                </div>
            </div>

            <button type="submit" class="px-6 py-2 rounded text-white font-medium btn-gold glow-hover whitespace-nowrap">
                Filter
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md overflow-hidden flex flex-col group">
                <div class="relative aspect-square overflow-hidden">
                    <img src="{{ $product->images->isNotEmpty() ? (Str::startsWith($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset('images/products/' . $product->images->first()->image_path)) : asset('images/placeholder-necklace.jpg') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition duration-300 ease-in-out group-hover:scale-105">
                    @if($product->is_featured)
                        <span
                            class="absolute top-2 left-2 bg-yellow-500 text-black text-xs font-bold px-2 py-0.5 rounded-full shadow">Featured</span>
                    @endif
                    <span
                        class="absolute top-2 right-2 {{ $product->stock > 0 ? 'bg-green-600' : 'bg-red-600' }} text-white text-xs font-semibold px-2 py-0.5 rounded-full shadow">
                        {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                    </span>
                </div>

                <div class="p-4 flex flex-col flex-grow">
                    <h2 class="text-lg font-semibold text-gray-100 hero-text truncate mb-1">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-400 mb-2">{{ $product->category->name ?? 'N/A' }}</p>
                    <p class="text-lg font-semibold text-white mb-3">
                        @if($product->discount_price)
                            <span class="line-through text-gray-500 text-sm">₹{{ number_format($product->price, 2) }}</span>
                            <span class="ml-2">₹{{ number_format($product->discount_price, 2) }}</span>
                        @else
                            <span>₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </p>

                    {{-- Actions (appear at the bottom) --}}
                    <div class="mt-auto flex justify-end space-x-3 pt-3 border-t border-[#d4af37]/20">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="text-blue-400 hover:text-blue-300 transition text-sm font-medium">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-400 hover:text-red-300 transition text-sm font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-400 py-12">
                <p class="text-lg">
                    @if(request('search') || request('category_id'))
                        No products found matching your filters.
                    @else
                        No products found.
                    @endif
                </p>
                @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.products.index') }}" class="text-blue-400 hover:underline mt-2 inline-block">Clear
                        Filters</a>
                @endif
            </div>
        @endforelse

    </div>
    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }}
    </div>
@endsection
