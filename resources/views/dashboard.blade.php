<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8 space-y-8">

            <h1 class="text-3xl font-bold mb-6">Dashboard Summary</h1>

            <div>
                <h2 class="text-xl font-semibold mb-3">Suppliers</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($suppliers as $supplier)
                    <div class="bg-white p-4 rounded shadow border">
                        <h3 class="font-bold">{{ $supplier['supplier_name'] }}</h3>
                        <p>Total Orders: {{ $supplier['total_orders'] }}</p>
                        <p>Total Amount: ${{ number_format($supplier['total_amount'], 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-3">Customers</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($customers as $customer)
                    <div class="bg-white p-4 rounded shadow border">
                        <h3 class="font-bold">{{ $customer['customer_name'] }}</h3>
                        <p>Total Orders: {{ $customer['total_orders'] }}</p>
                        <p>Total Amount: ${{ number_format($customer['total_amount'], 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-3">Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($products as $product)
                    <div class="bg-white p-4 rounded shadow border">
                        <h3 class="font-bold">{{ $product['product_name'] }}</h3>
                        <p>Total Orders: {{ $product['total_orders'] }}</p>
                        <p>Total Amount: ${{ number_format($product['total_amount'], 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>