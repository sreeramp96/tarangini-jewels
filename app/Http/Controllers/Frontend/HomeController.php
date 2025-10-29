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
        // Load the product's images and category
        $product->load('images', 'category');

        // Get 4 related products from the same category
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // Don't include this product
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }

    public function showCategory(Category $category)
    {
        // Load all products in this category, with their images
        $products = Product::with('images')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12); // Paginate for long lists

        return view('frontend.category-view', compact('category', 'products'));
    }
}
