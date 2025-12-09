@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">Orders</h2>
    </div>
    <x-table
        title="Order History"
        :pagination="$orders">
        <x-slot name="header">
            <th class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Order ID</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Customer</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Date</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Total</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Status</th>
            <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
        </x-slot>

        @foreach($orders as $order)
            <tr class="border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4">
                <td class="py-4 px-4 pl-9 xl:pl-11 text-primary">{{ $order->order_number }}</td>
                <td class="py-4 px-4 text-black dark:text-white">{{ $order->user->name }}</td>
                <td class="py-4 px-4 text-sm text-body">{{ $order->created_at->format('M d, Y') }}</td>
                <td class="py-4 px-4 text-black dark:text-white">₹{{ number_format($order->total_amount) }}</td>
                <td class="py-4 px-4">
                    <span class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium
                        @if($order->status === 'delivered') bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500
                        @elseif($order->status === 'pending') bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400
                        @elseif($order->status === 'cancelled') bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500
                        @else bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-500/15 dark:text-blue-light-500 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="py-4 px-4 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary"><x-bi-eye class="w-5 h-5"/></a>
                </td>
            </tr>
        @endforeach
    </x-table>
@endsection
