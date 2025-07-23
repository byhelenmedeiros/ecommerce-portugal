<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Mostrar o formulário de checkout
     */
    public function index()
    {
        return Inertia::render('CheckoutPage', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Finalizar o pedido
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
             'items.*.price' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'telefone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery',
            'shipping_method' => 'required|string|in:standard,express',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'telefone' => $request->telefone,
            'address' => $request->address,
            'status' => 'pendente',
            'total' => collect($request->items)->sum(fn ($i) => $i['price'] * $i['quantity']),
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('checkout.success')->with('success', 'Pedido realizado com sucesso!');
    }
}
