<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            'items.*.quantity' => 'required|integer|min:1',

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'door' => 'nullable|string|max:50',
            'floor' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'billing_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:mbway,visa,paypal,multibanco',
        ]);

        // Geração de número único de pedido
        $orderNumber = 'PED' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        // Criação da encomenda
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'name' => $request->name,
            'email' => $request->email,
            'telefone' => Auth::user()->telefone ?? null,
            'address' => $request->address,
            'door' => $request->door,
            'floor' => $request->floor,
            'location' => $request->location,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'district' => $request->district,
            'country' => $request->country,
            'billing_address' => $request->billing_address,
            'payment_method' => $request->payment_method,
            'status' => 'pendente',
            'total' => collect($request->items)->sum(fn ($i) => $i['price'] * $i['quantity']),
        ]);

        // Criação dos itens da encomenda
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('checkout.success')->with('success', 'Pedido #' . $orderNumber . ' realizado com sucesso!');
    }
}
