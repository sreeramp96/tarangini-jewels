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

class CheckoutController extends Controller
{
    public function index()
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

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $taxRate = 0.18;
        $shippingCost = ($subtotal > 0) ? 100.00 : 0.00;
        $taxes = $subtotal * $taxRate;
        $grandTotal = $subtotal + $taxes + $shippingCost;

        return view('frontend.checkout', compact(
            'cartItems',
            'subtotal',
            'taxes',
            'shippingCost',
            'grandTotal',
            'taxRate'
        ));
    }

    public function store(Request $request)
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

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->discount_price ?? $item->product->price) * $item->quantity;
        });

        $taxRate = 0.18;
        $shippingCost = 100.00;
        $taxes = $subtotal * $taxRate;
        $grandTotal = $subtotal + $taxes + $shippingCost;

        // --- TODO: Integrate real payment gateway (Stripe, Razorpay, etc.) here ---
        // For now, we'll assume payment is successful.

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TJ-' . strtoupper(Str::random(10)),
                'total_amount' => $grandTotal,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'taxes' => $taxes,
                'shipping_cost' => $shippingCost,
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

            CartItem::where('user_id', $user->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('checkout.success')->with('order_success', true);
    }
}
