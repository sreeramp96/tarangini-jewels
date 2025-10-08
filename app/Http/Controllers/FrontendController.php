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
        $featuredProducts = Product::take(8)->get();
        $offers = Offer::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        $testimonials = Testimonial::latest()->take(3)->get();

        return view('frontend.index', compact('featuredProducts', 'offers', 'testimonials'));
    }
}
