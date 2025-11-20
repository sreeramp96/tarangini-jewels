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
        $user = Auth::user();
        $wishlistedProducts = $user->wishlist()->with('images')->latest()->paginate(12);

        return view('frontend.wishlist', compact('wishlistedProducts'));
    }

    public function add(Product $product)
    {
        $user = Auth::user();

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
