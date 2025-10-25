{{-- @extends('admin.layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-semibold text-gray-200">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="px-6 py-2 rounded text-gray font-medium btn-gold glow-hover">
        Add New Product
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3">Stock</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">

            @forelse($products as $product)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ $product->category->name }}</td>
                <td class="px-6 py-4">₹{{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.products.edit', $product) }}"
                        class="text-blue-600 hover:underline">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                        class="inline-block ml-4"
                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">No products found.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
@endsection --}}
@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-200 hero-text">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-2 rounded text-white font-medium btn-gold glow-hover">
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-[#0a2e2b] text-gray-300 uppercase text-sm">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Stock</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-200">
                @forelse($products as $product)
                    <tr class="border-b border-[#d4af37]/20 hover:bg-[#0d4837]/60">
                        <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                        <td class="px-6 py-4">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">₹{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="text-blue-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                class="inline-block ml-4"
                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection