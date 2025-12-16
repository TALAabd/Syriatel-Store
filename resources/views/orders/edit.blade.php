<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Edit Order</h1>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @can('edit orders')
            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                @role('admin')
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                    <select name="customer_id" id="customer_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="customer_id" value="{{ auth()->user()->customer->id }}">
                @endrole

                <div class="bg-white shadow-md rounded-lg p-4 border">
                    <h2 class="text-lg font-semibold mb-3">Order Items</h2>

                    <p class="text-gray-500 text-sm mb-2">Select or deselect products and adjust quantities:</p>

                    @foreach($products as $product)
                    @php
                    $existingItem = $order->orderItems->firstWhere('product_id', $product->id);
                    $currentQuantity = $existingItem ? $existingItem->quantity : 0;
                    $checked = $existingItem ? 'checked' : '';
                    @endphp
                    <div class="flex items-center space-x-4 mb-2">
                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="w-4 h-4"
                            {{ $checked }}>

                        <span class="w-1/3">{{ $product->name }} (${{ number_format($product->price, 2) }})</span>

                        <input type="number"
                            name="quantities[{{ $product->id }}]"
                            min="0"
                            max="{{ $product->quantity + $currentQuantity }}"
                            value="{{ old('quantities.'.$product->id, $currentQuantity) }}"
                            class="w-24 border rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">

                        <span class="text-sm text-gray-500">Stock: {{ $product->quantity }}</span>
                    </div>
                    @endforeach
                </div>


                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount ($)</label>
                    <input type="number" step="0.01" name="total_amount" id="total_amount"
                        value="{{ old('total_amount', $order->total_amount) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('orders.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Order
                    </button>
                </div>
            </form>
            @endcan
        </div>
    </div>
</x-app-layout>