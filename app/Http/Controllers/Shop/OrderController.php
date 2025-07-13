<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Lista os pedidos do utilizador autenticado
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->with('items.product')->get();

        return inertia('Shop/Orders/Index', [
            'orders' => $orders
        ]);
    }

    // Mostra um pedido específico
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product');

        return inertia('Shop/Orders/Show', [
            'order' => $order
        ]);
    }

    // Cria novo pedido
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao criar pedido.']);
        }
    }
}
