<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Get the logged-in user and load their wishlist relationship
        $user = Auth::user();
        $wishlistedProducts = $user->wishlist()->with('images')->latest()->paginate(12);

        return view('frontend.wishlist', compact('wishlistedProducts'));
    }

    public function add(Product $product)
    {
        $user = Auth::user();

        // attach() checks for duplicates, so no need for an 'if' check.
        // If the item already exists, it does nothing.
        $user->wishlist()->attach($product->id);

        return back()->with('success', 'Item added to your wishlist!');
    }
    public function remove(Product $product)
    {
        $user = Auth::user();
        $user->wishlist()->detach($product->id);

        return back()->with('success', 'Item removed from your wishlist.');
    }
}
