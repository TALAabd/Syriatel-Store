<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Edit Customer</h1>

            <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- USER INFO --}}
                <div class="bg-white shadow-md rounded-lg p-4 border">
                    <h2 class="text-lg font-semibold mb-3">User Information</h2>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $customer->user->name ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->user->email ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Password <span class="text-gray-500">(Leave blank to keep current)</span></label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4 border">

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $customer->address) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>