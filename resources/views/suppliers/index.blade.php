<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Suppliers</h1>

                <a href="{{ route('suppliers.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Supplier
                </a>
            </div>

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Company Name</th>
                            <th class="px-4 py-2 border">Company Address</th>
                            <th class="px-4 py-2 border">Phone</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $supplier->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $supplier->company_name }}</td>
                            <td class="px-4 py-2 border">{{ $supplier->company_address }}</td>
                            <td class="px-4 py-2 border">{{ $supplier->phone }}</td>

                            <td class="px-4 py-2 border flex space-x-2">

                                <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                    class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                    Edit
                                </a>

                                <form action="{{ route('suppliers.destroy', ['supplier' => $supplier->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Supplier?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 border text-center">No suppliers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>