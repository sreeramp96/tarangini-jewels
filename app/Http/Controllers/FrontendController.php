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
        $featuredProducts = Product::latest()->with(['images'])->take(8)->get();
        $categories = Category::all();
        $offers = Offer::where('active', 1)->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('frontend.index', compact('featuredProducts', 'categories', 'offers', 'testimonials'));
    }
}
