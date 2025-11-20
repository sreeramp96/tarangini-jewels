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
        $productCount = Product::count();
        $categoryCount = Category::count();

        $pendingOrderCount = Order::where('status', 'pending')->count();

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
