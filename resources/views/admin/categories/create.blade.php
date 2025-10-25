{{-- @extends('admin.layouts.app')

@section('content')
<h1 class="text-3xl font-semibold text-gray-200 mb-6 hero-text ">Create New Category</h1>

<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl hero-text ">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" id="name" name="name"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                placeholder="e.g., Diamond Necklaces">
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-gray-700 font-medium mb-2">Slug (URL)</label>
            <input type="text" id="slug" name="slug"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                placeholder="e.g., diamond-necklaces">
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" name="description" rows="4"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
        </div>

        <div class="mt-6 flex items-center space-x-4">
            <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                Save Category
            </button>
            <a href="{{ route('admin.categories.index') }}"
                class="px-8 py-3 rounded text-white font-medium bg-red-500 glow-hover">
                Cancel
            </a>
        </div>
        @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </form>
</div>
@endsection --}}
@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 hero-text mb-6">Create New Category</h1>

    <div class="bg-[#0d4837] border border-[#d4af37]/40 p-8 rounded-lg shadow-md max-w-2xl">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <x-input-label for="name" :value="__('Category Name')" class="!text-gray-200" />
                <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="slug" :value="__('Slug (Optional)')" class="!text-gray-200" />
                <x-text-input id="slug" name="slug" type="text" class="block w-full mt-1" :value="old('slug')" />
                <p class="text-sm text-gray-400 mt-1">Leave blank to auto-generate from name.</p>
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="description" :value="__('Description')" class="!text-gray-200" />
                <textarea id="description" name="description" rows="4"
                    class="block w-full mt-1 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-6 flex items-center space-x-4">
                <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                    Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="px-8 py-3 rounded text-white font-medium bg-red-500 glow-hover">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection