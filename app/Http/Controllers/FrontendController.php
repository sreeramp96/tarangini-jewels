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
        $offers = Offer::where('active', true)->take(3)->get();
        $testimonials = Testimonial::latest()->take(5)->get();

        return view('frontend.index', compact('featuredProducts', 'offers', 'testimonials'));
    }
}
