<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }
    public function create()
    {
        //
    }
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'This is not your order.');
        }

        $order->load('items.product.images');

        return view('frontend.orders.show', compact('order'));
    }
}
