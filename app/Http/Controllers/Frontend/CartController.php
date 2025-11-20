<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\OrderService;

class CartController extends Controller
{
    public function index(OrderService $orderService)
    {
        $cartItems = collect();
        $totals = [
            'subtotal' => 0,
            'tax' => 0,
            'shipping' => 0,
            'grand_total' => 0,
            'tax_rate' => 0,
        ];

        if (Auth::check()) {
            $user = Auth::user();

            $dbItems = CartItem::where('user_id', $user->id)
                ->with(['product.images'])
                ->get();

            if ($dbItems->isNotEmpty()) {
                $totals = $orderService->calculateTotals($dbItems);
            }

            $cartItems = $dbItems->map(function ($item) {
                return (object)[
                    'id' => $item->id,
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->discount_price ?? $item->product->price,
                    'quantity' => $item->quantity,
                    'stock' => $item->product->stock,
                    'image' => $item->product->primary_image_url,
                    'slug' => $item->product->slug
                ];
            });
        } else {
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

        return view('frontend.cart', array_merge([
            'cartItems' => $cartItems
        ], $totals));
    }
    public function store(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if (Auth::check()) {
            $userId = Auth::id();
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $newQuantity = min($cartItem->quantity + $quantity, $product->stock);
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id'    => $userId,
                    'product_id' => $product->id,
                    'quantity'   => $quantity,
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            Session::put('cart', $cart);
        }

        if ($request->wantsJson()) {
            $newCount = 0;
            if (Auth::check()) {
                $newCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = Session::get('cart', []);
                foreach ($cart as $item) $newCount += $item['quantity'];
            }

            return response()->json([
                'message' => 'Product added to cart!',
                'cartCount' => $newCount
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $quantity = $validated['quantity'];

        if (Auth::check()) {
            $item = CartItem::findOrFail($id); // <-- Use $cartItem (from method signature)
            if ($item->user_id !== Auth::id()) abort(403);

            if ($quantity > $item->product->stock) {
                return back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $item->update(['quantity' => $quantity]);
        } else {
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
    public function destroy($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            if ($cartItem->user_id !== Auth::id()) abort(403);
            $cartItem->delete();
        } else {
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
