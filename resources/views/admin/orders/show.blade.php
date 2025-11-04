@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 hero-text mb-6">
        Order Details: <span class="text-brand-gold">{{ $order->order_number }}</span>
    </h1>

    @if(session('success'))
        <div class="bg-green-800/50 border border-green-600 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md overflow-hidden">
                <h2 class="text-xl font-semibold text-gray-200 hero-text p-6 border-b border-[#d4af37]/20">Items</h2>
                <div class="divide-y divide-[#d4af37]/20">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-6 hover:bg-[#0d4837]/60">
                            <div class="flex items-center space-x-4">
                                @php $image = $item->product->images->first(); @endphp
                                <img src="{{ $image ? (Str::startsWith($image->image_path, 'http') ? $image->image_path : asset('images/products/' . $image->image_path)) : asset('images/necklace.jpg') }}"
                                     alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border border-[#d4af37]/20">
                                <div>
                                    <p class="font-semibold text-gray-200">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-200">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                <p class="text-sm text-gray-400">(₹{{ number_format($item->price, 2) }} each)</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md p-6 text-gray-200">
                <h2 class="text-xl font-semibold hero-text mb-4">Price Summary</h2>
                <div class="space-y-2 border-b border-[#d4af37]/20 pb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Subtotal:</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Shipping:</span>
                        <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Taxes (18%):</span>
                        <span>₹{{ number_format($order->taxes, 2) }}</span>
                    </div>
                </div>
                <div class="flex justify-between text-2xl font-bold hero-text mt-4">
                    <span>Grand Total:</span>
                    <span class="text-brand-gold">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold hero-text text-gray-200 mb-4">Update Status</h2>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Order Status</label>
                    <select id="status" name="status"
                            class="block w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm bg-white text-gray-800">
                        <option value="pending" @selected($order->status == 'pending')>Pending</option>
                        <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                        <option value="delivered" @selected($order->status == 'delivered')>Delivered</option>
                        <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full btn-gold px-4 py-2 rounded font-medium mt-4">Update</button>
                </form>
            </div>

            <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md p-6 text-gray-300">
                <h2 class="text-xl font-semibold hero-text text-gray-200 mb-4">Customer Details</h2>
                <div class="space-y-3">
                    <p><strong>Name:</strong> {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    <hr class="border-[#d4af37]/20">
                    <p><strong>Shipping Address:</strong><br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                        {{ $order->shipping_zipcode }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
