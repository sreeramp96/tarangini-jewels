<?php

namespace App\Http\Controllers\Auth;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        $this->mergeSessionCartIntoDatabase($user);

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function mergeSessionCartIntoDatabase($user)
    {
        $sessionCart = Session::get('cart', []);
        if (empty($sessionCart)) return;

        foreach ($sessionCart as $productId => $item) {
            $quantity = $item['quantity'];
            $product = Product::find($productId);
            if (!$product) continue;

            // Check if item exists for this user
            $dbItem = CartItem::where('user_id', $user->id) // Query by user_id
                              ->where('product_id', $productId)
                              ->first();

            if ($dbItem) {
                // Update quantity logic...
                 $newQuantity = min($dbItem->quantity + $quantity, $product->stock);
                 $dbItem->quantity = $newQuantity;
                 $dbItem->save();
            } else {
                // Create new item linked directly to user
                 CartItem::create([
                    'user_id'    => $user->id, // Use user_id
                    'product_id' => $productId,
                    'quantity'   => min($quantity, $product->stock),
                ]);
            }
        }

        Session::forget('cart');
    }
}
