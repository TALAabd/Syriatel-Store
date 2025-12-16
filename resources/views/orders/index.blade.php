<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            @can('create orders')
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Orders</h1>
                <a href="{{ route('orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Order
                </a>
            </div>
            @endcan


            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Total Amount</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Created at</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $order->total_amount }}</td>
                            <td class="px-4 py-2 border">{{ $order->status }}</td>
                            <td class="px-4 py-2 border">{{ $order->created_at }}</td>
                            <td class="px-4 py-2 border flex space-x-2">
                                @can('edit orders')
                                <a href="{{ route('orders.edit', $order->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                    Edit
                                </a>
                                @endcan

                                @can('delete orders')
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                                @endcan

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 border text-center">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>