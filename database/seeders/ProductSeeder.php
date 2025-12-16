<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = Supplier::first();

        $products = [
            ['name' => 'iPhone 15 Pro', 'price' => 1200.00, 'quantity' => 15],
            ['name' => 'Samsung Galaxy S24', 'price' => 950.00, 'quantity' => 25],
            ['name' => 'MacBook', 'price' => 1600.00, 'quantity' => 10],
            ['name' => 'Dell XPS', 'price' => 1300.00, 'quantity' => 20],
            ['name' => 'Sony', 'price' => 400.00, 'quantity' => 30],
        ];

        foreach ($products as $p) {
            Product::create([
                'supplier_id' => $supplier->id,
                'name' => $p['name'],
                'price' => $p['price'],
                'quantity' => $p['quantity'],
            ]);
        }
    }
}
