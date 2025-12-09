@props(['orders' => []])

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/3 sm:px-6">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Orders</h3>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200">
                See all
            </a>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-t border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Order ID</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Customer</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Date</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Total</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr
                        class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/ transition">

                        {{-- Order ID --}}
                        <td class="py-3 whitespace-nowrap">
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="text-brand-500 hover:text-brand-600 font-medium text-theme-sm">
                                {{ $order->order_number }}
                            </a>
                        </td>

                        {{-- Customer --}}
                        <td class="py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-8 w-8 overflow-hidden rounded-full border border-gray-200 dark:border-gray-700">
                                    @if($order->user->avatar)
                                        <img src="{{ Storage::url($order->user->avatar) }}" alt="User"
                                            class="h-full w-full object-cover" />
                                    @else
                                        <div
                                            class="h-full w-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $order->user->name }}
                                </p>
                            </div>
                        </td>

                        {{-- Date --}}
                        <td class="py-3 whitespace-nowrap">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $order->created_at->format('M d, Y') }}
                            </p>
                        </td>

                        {{-- Total --}}
                        <td class="py-3 whitespace-nowrap">
                            <p class="text-gray-800 font-medium text-theme-sm dark:text-white/90">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="py-3 whitespace-nowrap">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium
                                        @if($order->status === 'delivered') bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500
                                        @elseif($order->status === 'pending') bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400
                                        @elseif($order->status === 'cancelled') bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500
                                        @else bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-500/15 dark:text-blue-light-500 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500 dark:text-gray-400 text-sm">
                            No recent orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
