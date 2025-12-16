<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::first();
        $products = Product::all();

        DB::transaction(function () use ($customer, $products) {
            for ($i = 1; $i <= 3; $i++) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'total_amount' => 0,
                    'status' => 'completed',
                ]);

                $total = 0;

                foreach ($products->random(rand(2, 3)) as $product) {
                    $quantity = rand(1, 3);
                    $totalPrice = $quantity * $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $product->price,
                        'total_price' => $totalPrice,
                    ]);

                    $total += $totalPrice;
                }

                $order->update(['total_amount' => $total]);
            }
        });
    }
}
