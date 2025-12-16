<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        $this->middleware('permission:view orders')->only(['index', 'show']);
        $this->middleware('permission:create orders')->only(['create', 'store']);
        $this->middleware('permission:edit orders')->only(['edit', 'update']);
        $this->middleware('permission:delete orders')->only(['destroy']);
    }

    public function index()
    {
        $orders = $this->orderRepository->all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = [];
        $products = Product::all();

        if (auth()->user()->hasRole('admin')) {
            $customers = Customer::all();
        }

        return view('orders.create', compact('customers', 'products'));
    }


    public function store(OrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $orderData = $request->only(['customer_id', 'total_amount', 'status']);
            $order = $this->orderRepository->create($orderData);

            if ($request->filled('product_ids')) {
                foreach ($request->product_ids as $productId) {
                    $quantity = $request->quantities[$productId] ?? 0;

                    if ($quantity > 0) {
                        $product = Product::find($productId);

                        $unitPrice = $product->price;
                        $totalPrice = $unitPrice * $quantity;

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                        ]);

                        $product->decrement('quantity', $quantity);
                    }
                }}
            $totalAmount = OrderItem::where('order_id', $order->id)->sum('total_price');
            $order->update(['total_amount' => $totalAmount]);
            });

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }
    public function edit($id)
    {
        $order = $this->orderRepository->find($id);
        $customers = [];
        $products = Product::all();

        if (auth()->user()->hasRole('admin')) {
            $customers = Customer::all();
        }

        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(OrderRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $orderData = $request->only(['customer_id', 'total_amount', 'status']);
            $this->orderRepository->update($id, $orderData);

            $order = $this->orderRepository->find($id);

            $order->orderItems()->delete();

            if ($request->filled('product_ids')) {
                foreach ($request->product_ids as $productId) {
                    $quantity = $request->quantities[$productId] ?? 0;

                    if ($quantity > 0) {
                        $product = Product::find($productId);
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $product->price,
                            'total_price' => $product->price * $quantity,
                        ]);
                    }
                }
            }
            $totalAmount = $order->orderItems()->sum('total_price');
            $order->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }


    public function destroy($id)
    {
        $this->orderRepository->delete($id);
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}