@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 hero-text mb-6">Edit Category: {{ $category->name }}</h1>

    <div class="bg-[#0d4837] border border-[#d4af37]/40 p-8 rounded-lg shadow-md max-w-2xl">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-input-label for="name" :value="__('Category Name')" class="!text-gray-200" />
                <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name', $category->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="slug" :value="__('Slug')" class="!text-gray-200" />
                <x-text-input id="slug" name="slug" type="text" class="block w-full mt-1" :value="old('slug', $category->slug)" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Current Image')" class="!text-gray-200" />
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                        class="w-32 h-32 object-cover rounded-lg mt-2 shadow-md">
                @else
                    <p class="text-sm text-gray-400 mt-2">No image has been uploaded for this category.</p>
                @endif
            </div>

            <div class="mb-4">
                <x-input-label for="image" :value="__('Change Image (Optional)')" class="!text-gray-200" />
                <input type="file" id="image" name="image" accept="image/*" class="block w-full text-sm text-gray-400 mt-1
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0 file:text-sm file:font-semibold
                                  file:bg-yellow-500 file:text-black hover:file:bg-yellow-600">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div class="mb-6">
                <x-input-label for="description" :value="__('Description')" class="!text-gray-200" />
                <textarea id="description" name="description" rows="4"
                    class="block w-full mt-1 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">{{ old('description', $category->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-6 flex items-center space-x-4">
                <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="px-8 py-3 rounded text-white font-medium btn-red glow-hover">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
