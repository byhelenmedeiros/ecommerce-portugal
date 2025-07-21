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

    return Inertia::render('Admin/Orders/Index', [
        'orders' => $orders
    ]);
}


  public function show(Order $order)
{
    $order->load(['user', 'items']); // eager load dos relacionamentos
    return Inertia::render('Admin/Orders/Show', [
        'order' => $order,
        'fiscalAddress' => $order->fiscal_address_id ? $order->fiscalAddress : null,
        'entregaAddress' => $order->entrega_address_id ? $order->entregaAddress : null,
        'items' => $order->items,
        'products' => $order->items->map(function ($item) {
            return $item->product; 
        }),
        'user' => $order->user,
        'statusOptions' => ['pendente', 'pago', 'enviado', 'cancelado'],
        'shippingMethods' => ['standard', 'express', 'pickup'],  
        'paymentMethods' => ['credit_card', 'paypal', 'bank_transfer'],  
        'adminNote' => $order->admin_note,
        'paymentProof' => $order->payment_proof,
    ])->with([
        'success' => session('success'),
    ]);
}

   public function updateStatus(Request $request, Order $order)
{
    $request->validate(['status' => 'required|in:pendente,pago,enviado,cancelado']);
    $order->update(['status' => $request->status]);
    return redirect()->back()->with('success', 'Status atualizado com sucesso.');
}

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pedido excluído com sucesso.');
    }
    
}