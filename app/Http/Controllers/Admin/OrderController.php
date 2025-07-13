<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return inertia('Admin/Orders/Index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return inertia('Admin/Orders/Show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled'
        ]);

        $order->update(['status' => $request->status]);
        return redirect()->back();
    }
}