<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Create Order</h1>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @can('create orders')
            <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount ($)</label>
                    <input type="number" name="total_amount" id="total_amount" step="0.01"
                        value="{{ old('total_amount') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                @role('admin')
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                    <select name="customer_id" id="customer_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="customer_id" value="{{ auth()->user()->customer->id }}">
                @endrole

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Products</label>

                    @foreach($products as $product)
                    <div class="flex items-center space-x-4 mb-2">
                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="w-4 h-4"
                            {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}>

                        <span>{{ $product->name }} - ${{ $product->price }} (Stock: {{ $product->quantity }})</span>

                        <input type="number" name="quantities[{{ $product->id }}]" min="0" max="{{ $product->quantity }}"
                            value="{{ old('quantities.'.$product->id, 0) }}"
                            class="ml-auto w-20 border rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('orders.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save Order
                    </button>
                </div>
            </form>
            @endcan
        </div>
    </div>
</x-app-layout>