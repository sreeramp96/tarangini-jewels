<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }
    public function edit(Order $order)
    {
        //
    }
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // TODO: Add logic here to email the user about the status update

        return back()->with('success', 'Order status updated successfully.');
    }
    public function destroy(Order $order)
    {
        //
    }
}
