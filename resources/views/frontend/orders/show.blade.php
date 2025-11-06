@extends('layouts.frontend')

@section('content')
<main class="bg-gray-100 py-16 px-6 lg:px-20">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-semibold text-gray-800 hero-text mb-4">
            Order Details: <span class="text-brand-gold">{{ $order->order_number }}</span>
        </h1>
        <p class="text-gray-500 mb-8">
            Placed on {{ $order->created_at->format('F d, Y') }} | Status:
            <span class="font-medium
                @switch($order->status)
                    @case('pending') text-yellow-600 @break
                    @case('shipped') text-blue-600 @break
                    @case('delivered') text-green-600 @break
                    @case('cancelled') text-red-600 @break
                    @default text-gray-600
                @endswitch">
                {{ ucfirst($order->status) }}
            </span>
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <h2 class="text-xl font-semibold text-gray-700 hero-text p-6 border-b border-gray-200">Items in this order</h2>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between p-6">
                                <div class="flex items-center space-x-4">
                                    @php $image = $item->product->images->first(); @endphp
                                    <img src="{{ $image ? (Str::startsWith($image->image_path, 'http') ? $image->image_path : asset('images/products/' . $image->image_path)) : asset('images/necklace.jpg') }}"
                                         alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-800 hero-text">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                    <p class="text-sm text-gray-500">(₹{{ number_format($item->price, 0) }} each)</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 text-gray-700">
                    <h2 class="text-xl font-semibold hero-text mb-4">Price Summary</h2>
                    <div class="space-y-2 border-b border-gray-200 pb-4">
                        <div class="flex justify-between"><span>Subtotal:</span> <span class="font-medium">₹{{ number_format($order->subtotal, 0) }}</span></div>
                        <div class="flex justify-between"><span>Shipping:</span> <span class="font-medium">₹{{ number_format($order->shipping_cost, 0) }}</span></div>
                        <div class="flex justify-between"><span>Taxes (18%):</span> <span class="font-medium">₹{{ number_format($order->taxes, 0) }}</span></div>
                    </div>
                    <div class="flex justify-between text-xl font-bold hero-text text-gray-800 mt-4">
                        <span>Grand Total:</span>
                        <span class="text-brand-gold">₹{{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-lg shadow-md p-6 text-gray-700">
                    <h2 class="text-xl font-semibold hero-text text-gray-800 mb-4">Shipping Details</h2>
                    <div class="space-y-3">
                        <p><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
                        <p>{{ $order->shipping_phone }}</p>
                        <hr class="border-gray-200">
                        <p>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                            {{ $order->shipping_zipcode }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
