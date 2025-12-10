@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">Products</h2>
    </div>
    <x-table
        title="All Products"
        :link="route('admin.products.create')"
        linkText="Add Product"
        :pagination="$products->links()">
        <x-slot name="header">
            <th class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Product Name</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Category</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Price</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Stock</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white text-right">Actions</th>
        </x-slot>
        @foreach($products as $product)
            <tr class="border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4 transition">
                <td class="py-4 px-4 pl-9 xl:pl-11">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="h-12.5 w-15 rounded-md overflow-hidden shrink-0">
                            <img src="{{ $product->primary_image_url }}" alt="Product" class="h-12 w-12 object-cover">
                        </div>
                        <p class="text-sm text-black dark:text-white font-medium">{{ $product->name }}</p>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <p class="text-sm text-black dark:text-white">{{ $product->category->name ?? 'Uncategorized' }}</p>
                </td>
                <td class="py-4 px-4">
                    <p class="text-sm text-black dark:text-white">₹{{ number_format($product->price) }}</p>
                </td>
                <td class="py-4 px-4">
                    <span
                        class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $product->stock < 5 ? 'bg-danger text-danger' : 'bg-success text-success' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center justify-end space-x-3.5">
                        <a href="{{ route('admin.products.edit', $product) }}" class="hover:text-primary">
                            <x-bi-pencil class="w-5 h-5 text-primary"/>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              class="inline-block" onsubmit="return confirm('Delete?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="hover:text-danger">
                                <x-bi-trash class="w-5 h-5"/>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
@endsection
