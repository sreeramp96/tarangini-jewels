<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-24">
    <h3 class="text-lg font-semibold hero-text text-gray-800 mb-4">Filters</h3>

    {{-- Form submits to the current URL (keeping category or search context) --}}
    <form action="{{ url()->current() }}" method="GET">

        {{-- Keep search query if it exists --}}
        @if(request('query'))
            <input type="hidden" name="query" value="{{ request('query') }}">
        @endif

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
            <select name="sort"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-gold focus:ring-brand-gold text-sm"
                onchange="this.form.submit()">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>New Arrivals</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High
                </option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low
                </option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
            <div class="flex items-center space-x-2">
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-gold focus:ring-brand-gold text-sm px-2 py-1">
                <span class="text-gray-400">-</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-gold focus:ring-brand-gold text-sm px-2 py-1">
            </div>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                    class="rounded border-gray-300 text-brand-gold shadow-sm focus:ring-brand-gold">
                <span class="ml-2 text-sm text-gray-600">In Stock Only</span>
            </label>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="w-full btn-gold py-2 rounded text-sm font-medium">Apply Filters</button>

            @if(request()->anyFilled(['sort', 'min_price', 'max_price', 'in_stock']))
                <a href="{{ url()->current() }}@if(request('query'))?query={{ request('query') }}@endif"
                    class="w-full text-center text-gray-500 text-xs hover:text-red-500 underline">
                    Clear Filters
                </a>
            @endif
        </div>
    </form>
</div>
