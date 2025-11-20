<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;

class CheckoutController extends Controller
{
    public function index(OrderService $orderService)
    {
        // In a real refactor, you might move this to a 'CartService'
        $cartItems = collect();
        $subtotal = 0;
        $userId = Auth::id();

        $dbItems = CartItem::where('user_id', $userId)
            ->with(['product.images'])
            ->get();

        if ($dbItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = $dbItems->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'name' => $item->product->name,
                'price' => $item->product->discount_price ?? $item->product->price,
                'quantity' => $item->quantity,
                'image' => $item->product->images->isNotEmpty() ? ($item->product->images->first()->image_path) : null,
            ];
        });

        $totals = $orderService->calculateTotals($cartItems);

        return view('frontend.checkout', array_merge([
            'cartItems' => $cartItems
        ], $totals));
    }

    public function store(Request $request, OrderService $orderService)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zipcode' => 'required|string|max:10',
        ]);

        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $totals = $orderService->calculateTotals($cartItems);
        $cartItemIds = $cartItems->pluck('id')->toArray();

        // --- TODO: Integrate real payment gateway (Stripe, Razorpay, etc.) here ---
        // For now, we'll assume payment is successful.

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TJ-' . strtoupper(Str::random(10)),
                'total_amount' => $totals['grand_total'],
                'status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'taxes' => $totals['tax'],
                'shipping_cost' => $totals['shipping'],
                'shipping_first_name' => $validated['first_name'],
                'shipping_last_name' => $validated['last_name'],
                'shipping_phone' => $validated['phone'],
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_state' => $validated['state'],
                'shipping_zipcode' => $validated['zipcode'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                ]);

                $product = $item->product;

                if ($product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            CartItem::whereIn('id', $cartItemIds)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed.');
        }

        return redirect()->route('checkout.success')->with('order_success', true);
    }
}
