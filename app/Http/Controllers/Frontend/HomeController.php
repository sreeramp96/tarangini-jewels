<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

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
        $heroCarouselProducts = $featuredProducts->filter(fn($p) => $p->images->isNotEmpty())->take(4);

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
    public function showCategory(Request $request, Category $category)
    {
        $query = Product::with('images')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('category_id', $category->id);

        $this->applyFilters($query, $request);

        $products = $query->paginate(12)->withQueryString();

        return view('frontend.category-view', compact('category', 'products'));
    }
    public function search(Request $request)
    {
        $queryTerm = $request->input('query');

        $query = Product::with('images')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where(function ($q) use ($queryTerm) {
                $q->where('name', 'LIKE', "%{$queryTerm}%")
                    ->orWhere('description', 'LIKE', "%{$queryTerm}%");
            });

        // Apply Filters using helper method
        $this->applyFilters($query, $request);

        $products = $query->paginate(16)->withQueryString();

        return view('frontend.search-results', compact('products', 'queryTerm'));
    }

    private function applyFilters(Builder $query, Request $request)
    {
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('in_stock')) {
            $query->where('stock', '>', 0);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }
    }
}
