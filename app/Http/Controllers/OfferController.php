<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
        return view('frontend.offers', compact('offers'));
    }
}
