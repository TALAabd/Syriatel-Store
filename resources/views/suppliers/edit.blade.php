<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Edit Supplier</h1>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-md rounded-lg p-4 border">

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name"
                            value="{{ old('name', $supplier->user->name ?? '') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email"
                            value="{{ old('email', $supplier->user->email ?? '') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Password <span class="text-gray-500 text-sm">(Leave blank to keep current)</span></label>
                        <input type="password" name="password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4 border">

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="company_name"
                            value="{{ old('company_name', $supplier->company_name) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Company Address</label>
                        <textarea name="company_address" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>{{ old('company_address', $supplier->company_address) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $supplier->phone) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('suppliers.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>