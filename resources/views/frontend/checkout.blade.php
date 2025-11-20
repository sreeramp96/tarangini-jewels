@extends('layouts.frontend')

@section('content')
    <main class="bg-gray-100 py-16 px-6 lg:px-20">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800 mb-8 text-center">Checkout</h1>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold hero-text text-gray-800 mb-6">Shipping Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" name="first_name" type="text" class="block w-full mt-1"
                                    :value="old('first_name', Auth::user()->name)" required />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" name="last_name" type="text" class="block w-full mt-1"
                                    :value="old('last_name')" required />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" name="phone" type="tel" class="block w-full mt-1"
                                    :value="old('phone', Auth::user()->phone)" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Street Address')" />
                                <x-text-input id="address" name="address" type="text" class="block w-full mt-1"
                                    :value="old('address')" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text" class="block w-full mt-1"
                                    :value="old('city')" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="state" :value="__('State / Province')" />
                                <x-text-input id="state" name="state" type="text" class="block w-full mt-1"
                                    :value="old('state')" required />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="zipcode" :value="__('Zip / Postal Code')" />
                                <x-text-input id="zipcode" name="zipcode" type="text" class="block w-full mt-1"
                                    :value="old('zipcode')" required />
                                <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-8 rounded-lg shadow-md sticky top-28">
                            <h2 class="text-2xl font-semibold hero-text text-gray-800 mb-6">Your Order</h2>

                            <div class="space-y-4 max-h-64 overflow-y-auto border-b border-gray-200 pb-4">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center space-x-4">
                                        <div class="relative flex-shrink-0">
                                            <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('images/products/' . $item->image)) : asset('images/necklace.jpg') }}"
                                                alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-md border">
                                            <span
                                                class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $item->quantity }}</span>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800 hero-text">{{ $item->name }}</p>
                                        </div>
                                        <div class="text-gray-700 font-semibold">
                                            ₹{{ number_format($item->price * $item->quantity, 0) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-2 mt-4 text-gray-700 border-t border-gray-100 pt-4">
                                <div class="flex justify-between text-sm">
                                    <span>Subtotal:</span>
                                    <span class="font-medium">₹{{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span>Taxes ({{ $tax_rate * 100 }}%):</span>
                                    <span class="font-medium">₹{{ number_format($tax, 2) }}</span>
                                </div>

                                <div class="flex justify-between text-sm">
                                    <span>Shipping:</span>
                                    <span class="font-medium">
                                        @if($shipping > 0)
                                            ₹{{ number_format($shipping, 2) }}
                                        @else
                                            <span class="text-green-600">FREE</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-gray-200 pt-4 mt-4">
                                <span class="text-lg font-semibold text-gray-800">Grand Total:</span>
                                <span class="text-xl font-bold text-brand-gold">₹{{ number_format($grand_total, 2) }}</span>
                            </div>

                            <button type="submit"
                                class="mt-6 w-full btn-gold px-8 py-3 rounded font-semibold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                Place Order
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
@endsection
