@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Category</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    placeholder="e.g., Diamond Necklaces" value="{{ old('name', $category->name) }}">
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-gray-700 font-medium mb-2">Slug (URL)</label>
                <input type="text" id="slug" name="slug"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    placeholder="e.g., diamond-necklaces" value="{{ old('slug', $category->slug) }}">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" {{ old('description', $category->description) }}></textarea>
            </div>

            <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                Save Category
            </button>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </form>
    </div>
@endsection
