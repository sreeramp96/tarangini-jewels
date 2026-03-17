@props(['product'])

<div
    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group relative h-full flex flex-col transition-all hover:shadow-lg"
    x-data>

    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-4/5 overflow-hidden">
        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover transition duration-700 ease-in-out group-hover:scale-105">

        <div class="absolute top-2 left-2 flex flex-col space-y-1">
            @if($product->discount_price && $product->price > 0)
                @php $discount = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-sm tracking-wider">
                    -{{ $discount }}%
                </span>
            @endif
        </div>
    </a>

    <div class="p-3 flex flex-col grow">
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h4
                class="text-sm font-medium text-gray-900 truncate font-serif group-hover:text-[#B48E43] transition-colors">
                {{ $product->name }}
            </h4>
        </a>

        <div class="flex items-center space-x-1 mt-1">
            <div class="flex text-[#B48E43]">
                @for($i = 0; $i < 5; $i++)
                    <x-heroicon-s-star
                        class="w-3 h-3 {{ $i < round($product->reviews_avg_rating) ? 'opacity-100' : 'opacity-30 text-gray-400' }}"/>
                @endfor
            </div>
            <span class="text-[10px] text-gray-400">({{ $product->reviews_count }})</span>
        </div>

        <div class="mt-2 mb-3 flex items-baseline gap-2">
            @if($product->discount_price)
                <span class="font-bold text-gray-900 text-base">₹{{ number_format($product->discount_price, 0) }}</span>
                <span class="line-through text-gray-400 text-xs">₹{{ number_format($product->price, 0) }}</span>
            @else
                <span class="font-bold text-gray-900 text-base">₹{{ number_format($product->price, 0) }}</span>
            @endif
        </div>

        <div class="mt-auto">
            <form action="{{ route('cart.store', $product->id) }}" method="POST" x-data="addToCartForm"
                  @submit.prevent="submit">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full bg-[#1B211A] text-[#EBD5AB] text-xs font-bold uppercase tracking-widest py-2.5 rounded-sm hover:bg-[#628141] hover:text-white transition-colors">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
        @csrf
        <button type="submit"
                class="bg-white/90 p-1.5 rounded-full shadow-sm text-gray-400 hover:text-red-500 transition hover:scale-110">
            <x-heroicon-o-heart class="w-4 h-4"/>
        </button>
    </form>
</div>
