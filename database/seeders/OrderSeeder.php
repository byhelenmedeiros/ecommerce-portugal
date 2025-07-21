<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Criar cliente
            $user = User::firstOrCreate(
                ['email' => 'cliente@demo.com'],
                [
                    'name' => 'Cliente Teste',
                    'password' => bcrypt('password'),
                ]
            );

            // Criar morada de faturação
            $billing = Address::create([
                'user_id' => $user->id,
                'type' => 'billing',
                'name' => 'Cliente Teste',
                'address' => 'Rua Fictícia 123',
                'postcode' => '1000-000',
                'city' => 'Lisboa',
                'country' => 'Portugal',
            ]);

            // Criar morada de entrega
            $shipping = Address::create([
                'user_id' => $user->id,
                'type' => 'shipping',
                'name' => 'Cliente Teste',
                'address' => 'Rua de Entrega 456',
                'postcode' => '2000-000',
                'city' => 'Porto',
                'country' => 'Portugal',
            ]);

            // Criar produtos
            $products = Product::factory()->count(3)->create();

            // Calcular totais
            $subtotal = $products->sum('price');
            $shippingCost = 5.00;
            $discount = 2.50;
            $total = $subtotal + $shippingCost - $discount;

            // Criar pedido
            $order = Order::create([
                'user_id' => $user->id,
                'billing_address_id' => $billing->id,
                'shipping_address_id' => $shipping->id,
                'status' => 'pendente',
                'payment_method' => 'MBWay',
                'shipping_method' => 'CTT Expresso',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'admin_note' => 'Aguardando confirmação do pagamento',
            ]);

            // Criar itens do pedido
            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => rand(1, 2),
                ]);
            }
        });
    }
}
