@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 hero-text mb-6">Create New Product</h1>

    <div class="bg-[#0d4837] border border-[#d4af37]/40 p-8 rounded-lg shadow-md max-w-4xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Product Name')" class="!text-gray-200" />
                        <x-text-input id="name" name="name" type="text" class="block w-full mt-1" :value="old('name')"
                            required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="category" :value="__('Category')" class="!text-gray-200" />
                        <select id="category" name="category_id"
                            class="block w-full mt-1 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm text-gray-700">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" class="!text-gray-200" />
                        <textarea id="description" name="description" rows="6"
                            class="block w-full mt-1 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price (₹)')" class="!text-gray-200" />
                            <x-text-input id="price" name="price" type="number" step="0.01" class="block w-full mt-1"
                                :value="old('price')" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stock" :value="__('Stock Quantity')" class="!text-gray-200" />
                            <x-text-input id="stock" name="stock" type="number" class="block w-full mt-1"
                                :value="old('stock')" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="discount_price" :value="__('Discount Price (Optional)')"
                            class="!text-gray-200" />
                        <x-text-input id="discount_price" name="discount_price" type="number" step="0.01"
                            class="block w-full mt-1" :value="old('discount_price')" />
                        <x-input-error :messages="$errors->get('discount_price')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label for="is_featured" class="inline-flex items-center">
                            <input id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500">
                            <span class="ml-2 text-sm text-gray-200">Is Featured? (Show on homepage)</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="images" :value="__('Product Images')" class="!text-gray-200" />
                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                            class="block w-full text-sm text-gray-400 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-500 file:text-black hover:file:bg-yellow-600 @error('images.*') border-red-500 @enderror">
                        <div id="image-preview-container" class="mt-4 flex flex-wrap gap-4"></div>
                        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center space-x-4">
                <button type="submit" class="px-8 py-3 rounded text-white font-medium btn-gold glow-hover">
                    Save Product
                </button>
                <a href="{{ route('admin.products.index') }}"
                    class="px-8 py-3 rounded text-white font-medium bg-red-500 glow-hover">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('images').addEventListener('change', function (event) {
            const previewContainer = document.getElementById('image-preview-container');
            previewContainer.innerHTML = '';
            if (!event.target.files) return;

            let isFirstFile = true;
            for (const file of event.target.files) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative w-32 h-32';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-lg shadow-md';
                    wrapper.appendChild(img);

                    if (isFirstFile) {
                        const badge = document.createElement('span');
                        badge.className = 'absolute top-1 left-1 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md';
                        badge.innerText = 'Primary';
                        wrapper.appendChild(badge);
                        isFirstFile = false;
                    }
                    previewContainer.appendChild(wrapper);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection