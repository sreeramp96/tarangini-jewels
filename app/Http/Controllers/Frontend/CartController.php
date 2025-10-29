<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = collect();
        $subtotal = 0;

        if (Auth::check()) {
            // Logged-in user: Load directly from CartItem using user_id
            $userId = Auth::id();
            $dbItems = CartItem::where('user_id', $userId)
                ->with(['product.images'])
                ->get();

            $cartItems = $dbItems->map(function ($item) {
                return (object)[
                    'id' => $item->id, // CartItem ID
                    'user_id' => $item->user_id, // Include user_id if needed
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->discount_price ?? $item->product->price,
                    'quantity' => $item->quantity,
                    'stock' => $item->product->stock,
                    'image' => $item->product->images->isNotEmpty() ? ($item->product->images->first()->image_path) : null,
                    'slug' => $item->product->slug
                ];
            });

            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        } else {
            // Guest session logic remains the same
            $sessionCart = Session::get('cart', []);
            $productIds = array_keys($sessionCart);

            if (!empty($productIds)) {
                $products = Product::with('images')->findMany($productIds);
                foreach ($products as $product) {
                    if (isset($sessionCart[$product->id])) {
                        $quantity = $sessionCart[$product->id]['quantity'];
                        $price = $product->discount_price ?? $product->price;
                        $cartItems->push((object)[ /* ... mapping logic ... */]);
                        $subtotal += $price * $quantity;
                    }
                }
            }
        }

        // --- Calculate Price Breakdown ---
        $taxRate = 0.18;
        $shippingCost = ($subtotal > 0) ? 100.00 : 0.00;
        $taxes = $subtotal * $taxRate;
        $grandTotal = $subtotal + $taxes + $shippingCost;
        // --- END: Price Breakdown ---

        return view('frontend.cart', compact(
            'cartItems',
            'subtotal',
            'taxes',
            'shippingCost',
            'grandTotal',
            'taxRate' // Pass taxRate too
        ));
    }

    public function store(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        // ... (quantity validation) ...

        if (Auth::check()) {
            // Logged-in user: Use CartItem with user_id
            $userId = Auth::id();
            $cartItem = CartItem::where('user_id', $userId) // Query by user_id
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // ... (update quantity logic) ...
                $newQuantity = min($cartItem->quantity + $quantity, $product->stock);
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id'    => $userId, // Link directly to user
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                ]);
            }
        } else {
            // Guest session logic remains the same
            $cart = Session::get('cart', []);
            // ... (rest of session logic) ...
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }


    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $quantity = $validated['quantity'];

        if (Auth::check()) {
            $item = CartItem::findOrFail($id); // <-- Use $cartItem (from method signature)
            if ($item->user_id !== Auth::id()) abort(403); // Use $item now

            if ($quantity > $item->product->stock) { // Use $item
                return back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $item->update(['quantity' => $quantity]); // Use $item

        } else {
            // Session logic remains the same
            $cart = Session::get('cart', []);
            $productId = $id;
            if (isset($cart[$productId])) {
                $product = Product::find($productId);
                if (!$product || $quantity > $product->stock) {
                    return back()->with('error', 'Requested quantity exceeds available stock.');
                }
                $cart[$productId]['quantity'] = $quantity;
                Session::put('cart', $cart);
            } else {
                return back()->with('error', 'Item not found in cart.');
            }
        }
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            // Check ownership using user_id
            if ($cartItem->user_id !== Auth::id()) abort(403);
            $cartItem->delete();
        } else {
            // Session logic remains the same
            $cart = Session::get('cart', []);
            $productId = $id;
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);
            }
        }
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }
}
