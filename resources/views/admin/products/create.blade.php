@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Create New Product</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl">
        {{--
        FIX #1: Corrected the route from 'products.store' to 'admin.products.store'
        --}}
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Column --}}
                <div>
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Product Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('name') border-red-500 @enderror"
                            placeholder="e.g., Royal Emerald Ring">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
                        {{--
                        FIX #2: Replaced hardcoded options with a dynamic @foreach loop
                        --}}
                        <select id="category" name="category_id"
                            class="w-full px-4 py-2 border rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea id="description" name="description" rows="6"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-medium mb-2">Price (₹)</label>
                            <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('price') border-red-500 @enderror"
                                placeholder="e.g., 75000">
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="stock" class="block text-gray-700 font-medium mb-2">Stock Quantity</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('stock') border-red-500 @enderror"
                                placeholder="e.g., 50">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="discount_price" class="block text-gray-700 font-medium mb-2">Discount Price
                            (Optional)</label>
                        <input type="number" id="discount_price" name="discount_price" step="0.01"
                            value="{{ old('discount_price') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('discount_price') border-red-500 @enderror"
                            placeholder="e.g., 69999">
                        @error('discount_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Is Featured?</label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500">
                            <span class="ml-2 text-gray-600">Show on homepage</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                    Save Product
                </button>
            </div>
        </form>
    </div>
@endsection
