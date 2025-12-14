@props(['product'])

<div class="bg-white rounded-lg shadow-sm overflow-hidden group relative h-full flex flex-col" x-data
     x-init="
        gsap.from($el, {
            scrollTrigger: {
                trigger: $el,
                start: 'top 85%', // Start animation when top of card hits 85% of viewport
                toggleActions: 'play none none reverse'
            },
            y: 50,
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        })
     ">
    <a href="{{ route('products.show', $product->slug) }}" class="block grow">
        {{-- Image Container --}}
        <div class="relative overflow-hidden aspect-4/5">
            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover transition duration-700 ease-in-out group-hover:scale-110">

            {{-- Badges --}}
            <div class="absolute top-2 left-2 flex flex-col space-y-1">
                @if($product->discount_price && $product->price > 0)
                    @php
                        $discount = round((($product->price - $product->discount_price) / $product->price) * 100);
                    @endphp
                    <span class="bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                        {{ $discount }}% OFF
                    </span>
                @endif
                @if($product->stock <= 0)
                    <span class="bg-gray-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                        Out of stock
                    </span>
                @endif
            </div>

            {{-- Wishlist Button --}}
            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                @csrf
                <button type="submit"
                    class="bg-white p-1.5 rounded-full shadow-sm text-gray-400 hover:text-red-500 transition transform hover:scale-110"
                    title="Add to Wishlist">
                    <x-heroicon-o-heart class="w-5 h-5" />
                </button>
            </form>
        </div>

        {{-- Product Info --}}
        <div class="p-4 text-center">
            <h4 class="text-md font-medium text-gray-800 truncate hero-text">{{ $product->name }}</h4>

            {{-- Rating (Assuming you have a star-rating component, or just use icons here) --}}
            <div class="flex justify-center mt-2 items-center space-x-1">
                <span class="text-yellow-400 flex">
                    @for($i = 0; $i < 5; $i++)
                        <x-heroicon-s-star
                            class="w-3 h-3 {{ $i < round($product->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}" />
                    @endfor
                </span>
                <span class="text-xs text-gray-400">({{ $product->reviews_count }})</span>
            </div>

            {{-- Price --}}
            <div class="mt-2 space-x-1">
                @if($product->discount_price)
                    <span class="line-through text-gray-400 text-sm">₹{{ number_format($product->price, 0) }}</span>
                    <span
                        class="font-semibold text-gray-800 text-lg">₹{{ number_format($product->discount_price, 0) }}</span>
                @else
                    <span class="font-semibold text-gray-800 text-lg">₹{{ number_format($product->price, 0) }}</span>
                @endif
            </div>

            {{-- Add to Cart --}}
            <button
                class="mt-3 w-full bg-[#0b3d2e] text-brand-gold px-4 py-2 text-sm rounded-sm hover:bg-[#0d4837] transition uppercase tracking-wider font-semibold">
                Add to Cart
            </button>
        </div>
    </a>
</div>
