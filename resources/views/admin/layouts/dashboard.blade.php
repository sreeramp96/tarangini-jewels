@extends('admin.layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-200 mb-6 hero-text">Admin Dashboard</h1>

    {{-- Cards are now dynamic --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 hero-text ">

        <div class="bg-[#0d4837] border border-[#d4af37]/40 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold hero-text text-[#d4af37]">Total Products</h2>
            <p class="text-3xl text-white font-semibold mt-2">{{ $productCount }}</p>
        </div>

        <div class="bg-[#0d4837] border border-[#d4af37]/40 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold hero-text text-[#d4af37]">Total Categories</h2>
            <p class="text-3xl text-white font-semibold mt-2">{{ $categoryCount }}</p>
        </div>

        <div class="bg-[#0d4837] border border-[#d4af37]/40 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold hero-text text-[#d4af37]">Pending Orders</h2>
            <p class="text-3xl text-white font-semibold mt-2">{{ $pendingOrderCount }}</p>
        </div>

        {{-- NEW ELEMENT: Total Customers --}}
        <div class="bg-[#0d4837] border border-[#d4af37]/40 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold hero-text text-[#d4af37]">Total Customers</h2>
            <p class="text-3xl text-white font-semibold mt-2">{{ $customerCount }}</p>
        </div>
    </div>

    {{-- NEW ELEMENT: Recent Orders Table --}}
    <div class="mt-12 hero-text">
        <h2 class="text-2xl font-semibold text-gray-200 mb-4 hero-text">Recent Orders</h2>

        <div class="bg-[#0d4837] border border-[#d4af37]/40 rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0a2e2b] text-gray-300 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">

                    @forelse($recentOrders as $order)
                        <tr class="border-b border-[#d4af37]/20 hover:bg-[#0d4837]/60">
                            <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                            @if($order->status == 'pending') bg-yellow-600 text-yellow-100 @endif
                                                            @if($order->status == 'paid') bg-green-600 text-green-100 @endif
                                                            @if($order->status == 'shipped') bg-blue-600 text-blue-100 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">₹{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">No recent orders found.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection