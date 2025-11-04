@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 hero-text mb-6">Orders</h1>

    @if(session('success'))
        <div class="bg-green-800/50 border border-green-600 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[800px]">
                <thead class="bg-[#0a2e2b] text-gray-300 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    @forelse($orders as $order)
                        <tr class="border-b border-[#d4af37]/20 hover:bg-[#0d4837]/60">
                            <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @switch($order->status)
                                        @case('pending') bg-yellow-600 text-yellow-100 @break
                                        @case('shipped') bg-blue-600 text-blue-100 @break
                                        @case('delivered') bg-green-600 text-green-100 @break
                                        @case('cancelled') bg-red-600 text-red-100 @break
                                        @default bg-gray-600 text-gray-100
                                    @endswitch">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('d M, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-400 hover:underline">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-6 text-gray-300">
        {{ $orders->links() }}
    </div>
@endsection
