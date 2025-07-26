<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;

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
     * Processar o checkout e criar o pedido
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
        'payment_method' => 'required|string|in:stripe',
    ]);

    $orderNumber = 'PED' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

    $total = collect($request->items)->sum(fn ($i) => $i['price'] * $i['quantity']);

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
        'total' => $total,
    ]);

    foreach ($request->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    // Stripe Checkout Integration
    Stripe::setApiKey(config('services.stripe.secret'));

    $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Pedido #' . $order->order_number,
                ],
                'unit_amount' => intval($order->total * 100), // em cêntimos
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('checkout.success'),
        'cancel_url' => route('checkout.index'),
        'customer_email' => $order->email,
        'metadata' => [
            'order_id' => $order->id,
            'order_number' => $order->order_number
        ]
    ]);

    return redirect($session->url);
}
  public function createPaymentIntent(Request $request)
    {
        // 1) Validação
        $request->validate([
            'address'       => 'required|string',
            'postal_code'   => 'required|string',
            'city'          => 'required|string',
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price'    => 'required|numeric|min:0',
        ]);

        // 2) Cria o pedido no banco
        $order = Order::create([
            'user_id'     => Auth::id(),
            'order_number'=> 'PED'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'city'        => $request->city,
            'status'      => 'pending',
            'total'       => collect($request->items)
                               ->sum(fn($i) => $i['price'] * $i['quantity']),
        ]);

        foreach ($request->items as $i) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $i['id'],
                'quantity'   => $i['quantity'],
                'price'      => $i['price'],
            ]);
        }

        // 3) Cria o PaymentIntent no Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount'   => intval($order->total * 100),
            'currency' => 'eur',
            'metadata' => ['order_id' => $order->id],
        ]);

        // 4) Retorna para o front
        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'order_id'      => $order->id,
        ]);
    }
}