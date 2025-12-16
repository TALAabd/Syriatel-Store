<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('products.orderItems')->get()->map(function ($supplier) {
            $totalOrders = 0;
            $totalAmount = 0;

            foreach ($supplier->products as $product) {
                $totalOrders += $product->orderItems->count();
                $totalAmount += $product->orderItems->sum('total_price');
            }

            return [
                'supplier_name' => $supplier->company_name,
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount,
            ];
        });

        $customers = Customer::with('orders')->get()->map(function ($customer) {
            $totalOrders = $customer->orders->count();
            $totalAmount = $customer->orders->sum('total_amount');

            return [
                'customer_name' => $customer->user->name,
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount,
            ];
        });

        $products = Product::with('orderItems')->get()->map(function ($product) {
            $totalOrders = $product->orderItems->count();
            $totalAmount = $product->orderItems->sum('total_price');

            return [
                'product_name' => $product->name,
                'total_orders' => $totalOrders,
                'total_amount' => $totalAmount,
            ];
        });

        return view('dashboard', compact('suppliers', 'customers', 'products'));
    }
    public function log(){
        $daily = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $monthly = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $yearly = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return view('log', compact('daily', 'monthly', 'yearly'));
    }
}
