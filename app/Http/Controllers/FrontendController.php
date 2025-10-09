<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Testimonial;

class FrontendController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(8)->get();
        $categories = Category::all();
        $offers = Offer::where('active', 1)->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('frontend.index', compact('featuredProducts', 'categories', 'offers', 'testimonials'));
    }

    public function shop()
    {
        $products = Product::paginate(12);
        return view('frontend.shop', compact('products'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('frontend.product', compact('product'));
    }

    public function offers()
    {
        $offers = Offer::where('active', 1)->get();
        return view('frontend.offers', compact('offers'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::latest()->get();
        return view('frontend.testimonials', compact('testimonials'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
