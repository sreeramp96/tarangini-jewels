@extends('layouts.frontend')

@section('content')
    <main class="bg-gray-100 py-16 px-6 lg:px-20 min-h-[60vh]">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800 mb-8 text-center">Your Shopping Cart</h1>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="text-center bg-white p-12 rounded-lg shadow-md">
                    <p class="text-xl text-gray-600 mb-6">Your cart is currently empty.</p>
                    <a href="{{ route('home') }}" class="btn-gold px-8 py-3 rounded font-semibold text-lg inline-block">
                        Continue Shopping
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="hidden md:block">
                        <div
                            class="grid grid-cols-6 gap-4 px-6 py-3 bg-gray-50 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="col-span-2">Product</div>
                            <div>Price</div>
                            <div>Quantity</div>
                            <div>Total</div>
                            <div>Remove</div>
                        </div>
                    </div>

                    @foreach($cartItems as $item)
                        <div class="grid grid-cols-6 gap-4 items-center px-6 py-4 border-b border-gray-200">
                            <div class="col-span-6 md:col-span-2 flex items-center space-x-4">
                                <a href="{{ route('products.show', $item->slug) }}" class="flex-shrink-0">
                                    <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('images/products/' . $item->image)) : asset('images/necklace.jpg') }}"
                                        alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-md border border-gray-200">
                                </a>
                                <div>
                                    <a href="{{ route('products.show', $item->slug) }}"
                                        class="font-medium text-gray-800 hover:text-brand-gold hero-text">{{ $item->name }}</a>
                                    {{-- Maybe add SKU or options here later --}}
                                </div>
                            </div>

                            <div class="col-span-2 md:col-span-1 text-gray-600">
                                <span class="md:hidden font-medium text-gray-500 text-xs uppercase">Price: </span>
                                ₹{{ number_format($item->price, 0) }}
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                    <input type="number" id="quantity-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}"
                                        min="1" max="{{ $item->stock }}"
                                        class="w-16 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-brand-gold focus:border-brand-gold text-center text-gray-800"
                                        onchange="this.form.submit()">
                                    @error('quantity')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>

                            <div class="col-span-1 text-gray-800 font-semibold">
                                <span class="md:hidden font-medium text-gray-500 text-xs uppercase">Total: </span>
                                ₹{{ number_format($item->price * $item->quantity, 0) }}
                            </div>

                            <div class="col-span-1 text-right">
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Remove Item">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-right">

                        <div class="space-y-2 mb-6 text-gray-700">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span class="font-medium">₹{{ number_format($subtotal, 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Taxes ({{ $taxRate * 100 }}%):</span>
                                <span class="font-medium">₹{{ number_format($taxes, 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping:</span>
                                <span
                                    class="font-medium">{{ $shippingCost > 0 ? '₹' . number_format($shippingCost, 0) : 'FREE' }}</span>
                            </div>
                        </div>

                        <p class="text-xl font-semibold text-gray-800 border-t border-gray-200 pt-4">
                            Grand Total: <span class="ml-2">₹{{ number_format($grandTotal, 0) }}</span>
                        </p>

                        <p class="text-sm text-gray-500 mt-1">Shipping & taxes calculated.</p>

                        <div class="mt-6">
                            <a href="#" class="btn-gold px-8 py-3 rounded font-semibold text-lg inline-block">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
