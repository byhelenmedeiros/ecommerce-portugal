<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
         $this->authorize('viewAny', Order::class);

        $orders = Order::with('user')->latest()->paginate(15);
        return inertia('Admin/Orders/Index', compact('orders'));
    }

  public function show(Order $order)
{
    $order->load(['user', 'items']); // eager load dos relacionamentos
    return Inertia::render('Admin/Orders/Show', [
        'order' => $order
    ]);
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