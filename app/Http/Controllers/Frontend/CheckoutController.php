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
        // This logic is duplicated from CartController::index().
        // In a real refactor, you might move this to a 'CartService'
        $cartItems = collect();
        $subtotal = 0;
        $userId = Auth::id();

        $dbItems = CartItem::where('user_id', $userId)
            ->with(['product.images'])
            ->get();

        if ($dbItems->isEmpty()) {
            // Don't let users check out with an empty cart
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

        $taxRate = 0.18; // 18%
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

        // 1. Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zipcode' => 'required|string|max:10',
        ]);

        // 2. Get the cart items again (to be safe)
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        // 3. Calculate final totals again (server-side)
        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->discount_price ?? $item->product->price) * $item->quantity;
        });
        $taxRate = 0.18;
        $shippingCost = 100.00;
        $taxes = $subtotal * $taxRate;
        $grandTotal = $subtotal + $taxes + $shippingCost;

        // --- TODO: Integrate real payment gateway (Stripe, Razorpay, etc.) here ---
        // For now, we'll assume payment is successful.

        // 4. Create the Order in a database transaction
        // This ensures if one step fails, all steps are rolled back.
        DB::beginTransaction();

        try {
            // Create the Order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'TJ-' . strtoupper(Str::random(10)),
                'total_amount' => $grandTotal,
                'status' => 'pending', // 'pending' until payment is confirmed
                // Add address fields to your 'orders' table migration if you want to store them
                // 'shipping_address' => json_encode($validated),
            ]);

            // Create Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                ]);
            }

            // 5. Clear the user's cart
            CartItem::where('user_id', $user->id)->delete();

            // 6. Commit the transaction
            DB::commit();

        } catch (\Exception $e) {
            // If anything went wrong, roll back
            DB::rollBack();
            // Log the error: \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again.');
        }

        // 7. Redirect to a success page
        return redirect()->route('checkout.success')->with('order_success', true);
    }
}
