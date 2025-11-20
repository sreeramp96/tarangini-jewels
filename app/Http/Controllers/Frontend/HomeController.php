<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('images')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::all();

        $heroCarouselProducts = $featuredProducts->filter(function ($product) {
            return $product->images->isNotEmpty();
        })->take(4);

        return view('frontend.home', compact(
            'featuredProducts',
            'categories',
            'heroCarouselProducts'
        ));
    }
    public function showProduct(Product $product)
    {
        $product->load('images', 'category');
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
    public function showCategory(Category $category)
    {
        $products = Product::with('images')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('frontend.category-view', compact('category', 'products'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return back()->with('error', 'Please enter a search term.');
        }

        $products = Product::with('images')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(16);

        return view('frontend.search-results', compact('products', 'query'));
    }
}
