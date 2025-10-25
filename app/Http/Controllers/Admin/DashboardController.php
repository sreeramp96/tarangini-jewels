<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
public function index()
    {
        // 1. Get counts for the cards
        $productCount = Product::count();
        $categoryCount = Category::count();

        // Assuming 'Order' model exists from our previous plan
        $pendingOrderCount = Order::where('status', 'pending')->count();

        // 2. Get data for new elements
        $customerCount = User::where('is_admin', false)->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.layouts.dashboard', compact(
            'productCount',
            'categoryCount',
            'pendingOrderCount',
            'customerCount',
            'recentOrders'
        ));
    }
}
