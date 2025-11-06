@extends('layouts.frontend')

@section('content')
<main class="bg-gray-100 py-16 px-6 lg:px-20 min-h-[60vh]">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800 mb-8 text-center">My Orders</h1>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Order Number</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->created_at->format('d M, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @switch($order->status)
                                            @case('pending') bg-yellow-100 text-yellow-800 @break
                                            @case('shipped') bg-blue-100 text-blue-800 @break
                                            @case('delivered') bg-green-100 text-green-800 @break
                                            @case('cancelled') bg-red-100 text-red-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold">₹{{ number_format($order->total_amount, 0) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('orders.show', $order) }}" class="text-brand-gold hover:underline font-medium">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">You have not placed any orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
</main>
@endsection
