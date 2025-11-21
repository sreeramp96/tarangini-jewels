@use('Illuminate\Support\Str')
@extends('layouts.frontend')

@section('content')
    <main class="bg-gray-50 py-16 px-6 lg:px-20 min-h-[60vh]">
        <div class="max-w-5xl mx-auto" x-data="shoppingCart({
                 subtotal: {{ $subtotal }},
                 tax: {{ $tax }},
                 shipping: {{ $shipping }},
                 grandTotal: {{ $grand_total }},
                 itemCount: {{ $cartItems->count() }}
             })">

            <h1 class="text-3xl lg:text-4xl font-bold hero-text text-gray-800 mb-8 text-center">Your Shopping Cart</h1>

            <div x-show="itemCount === 0" style="display: none;" class="text-center bg-white p-12 rounded-lg shadow-md">
                <x-heroicon-o-shopping-bag class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                <p class="text-xl text-gray-600 mb-6">Your cart is currently empty.</p>
                <a href="{{ route('home') }}" class="btn-gold px-8 py-3 rounded font-semibold text-lg inline-block">
                    Continue Shopping
                </a>
            </div>

            <div x-show="itemCount > 0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                    <div
                        class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <div class="col-span-6">Product</div>
                        <div class="col-span-2 text-center">Price</div>
                        <div class="col-span-2 text-center">Quantity</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($cartItems as $item)
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center px-6 py-6 transition-opacity duration-300"
                                x-data="{
                                         qty: {{ $item->quantity }},
                                         price: {{ $item->price }},
                                         loading: false,
                                         removed: false
                                     }" x-show="!removed" x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95">
                                <div class="col-span-1 md:col-span-6 flex items-center space-x-4">
                                    <a href="{{ route('products.show', $item->slug) }}" class="flex-shrink-0">
                                        <img src="{{ $item->image ? (Str::startsWith($item->image, 'http') ? $item->image : Storage::url($item->image)) : asset('images/necklace.jpg') }}"
                                            alt="{{ $item->name }}"
                                            class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                    </a>
                                    <div>
                                        <a href="{{ route('products.show', $item->slug) }}"
                                            class="font-medium text-gray-900 hover:text-brand-gold hero-text text-lg block mb-1">{{ $item->name }}</a>
                                        <button @click="removeItem('{{ route('cart.destroy', $item->id) }}', $el)"
                                            class="text-red-500 hover:text-red-700 text-sm flex items-center gap-1 transition">
                                            <x-heroicon-o-trash class="w-4 h-4" /> Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="col-span-1 md:col-span-2 text-gray-600 md:text-center font-medium">
                                    <span class="md:hidden text-gray-400 text-xs">Price: </span>
                                    <span x-text="formatMoney(price)"></span>
                                </div>
                                <div class="col-span-1 md:col-span-2 flex md:justify-center">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button
                                            @click="qty > 1 ? updateQty('{{ route('cart.update', $item->id) }}', qty - 1) : null"
                                            class="px-3 py-1 hover:bg-gray-100 text-gray-600 transition disabled:opacity-50"
                                            :disabled="loading || qty <= 1">-</button>

                                        <input type="number" x-model="qty" readonly
                                            class="w-10 text-center border-none p-0 text-gray-800 font-semibold focus:ring-0">

                                        <button @click="updateQty('{{ route('cart.update', $item->id) }}', qty + 1)"
                                            class="px-3 py-1 hover:bg-gray-100 text-gray-600 transition disabled:opacity-50"
                                            :disabled="loading || qty >= {{ $item->stock }}">+</button>
                                    </div>
                                </div>
                                <div class="col-span-1 md:col-span-2 text-right font-bold text-gray-900">
                                    <span class="md:hidden text-gray-400 text-xs">Total: </span>
                                    <span x-text="formatMoney(price * qty)"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-gray-50 p-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-end">
                            <div class="w-full md:w-1/3 space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium text-gray-900" x-text="formatMoney(subtotal)"></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Tax (18%)</span>
                                    <span class="font-medium text-gray-900" x-text="formatMoney(tax)"></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="shipping > 0 ? formatMoney(shipping) : 'FREE'"></span>
                                </div>
                                <div
                                    class="flex justify-between text-xl font-bold text-gray-900 pt-4 border-t border-gray-200">
                                    <span>Total</span>
                                    <span class="text-brand-gold" x-text="formatMoney(grandTotal)"></span>
                                </div>

                                <div class="pt-6">
                                    <a href="{{ route('checkout.index') }}"
                                        class="block w-full btn-gold py-3 rounded-lg font-bold text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition">
                                        Proceed to Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('shoppingCart', (initialData) => ({
                subtotal: initialData.subtotal,
                tax: initialData.tax,
                shipping: initialData.shipping,
                grandTotal: initialData.grandTotal,
                itemCount: initialData.itemCount,

                formatMoney(amount) {
                    return '₹' + new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(amount);
                },

                updateQty(url, newQty) {
                    // 'this' refers to the child row component context in the template,
                    // but we need the parent context for totals.
                    // Alpine magic handles scope automatically if we call this from child.

                    // Accessing child data directly is tricky here, so we rely on the scope.
                    // We set loading on the *current* element's scope (the row).
                    this.loading = true;

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ quantity: newQty })
                    })
                        .then(res => {
                            if (!res.ok) throw res;
                            return res.json();
                        })
                        .then(data => {
                            this.qty = newQty;

                            // Update Global Cart State (Parent Scope)
                            // We use $data to access the parent scope variables since we are inside a child scope
                            this.subtotal = data.totals.subtotal;
                            this.tax = data.totals.tax;
                            this.shipping = data.totals.shipping;
                            this.grandTotal = data.totals.grand_total;
                            window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cartCount } }));
                        })
                        .catch(async err => {
                            console.error(err);
                            if (err.json) {
                                const e = await err.json();
                                alert(e.message);
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                },

                removeItem(url, el) {
                    if (!confirm('Are you sure?')) return;

                    // We are inside the child scope (row).
                    // 'el' is the button. We can use 'this' to access row data.

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.removed = true;
                                this.subtotal = data.totals.subtotal;
                                this.tax = data.totals.tax;
                                this.shipping = data.totals.shipping;
                                this.grandTotal = data.totals.grand_total;
                                this.itemCount = this.itemCount - 1;
                                window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cartCount } }));
                            }
                        });
                }
            }));
        });
    </script>
@endsection
