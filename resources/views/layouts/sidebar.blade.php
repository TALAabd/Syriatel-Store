<div class="w-64 bg-gray-900 text-white min-h-screen p-4 space-y-4">
    <h1 class="text-2xl font-bold mb-6">Syriatel Store</h1>

    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-700' : '' }}">
            Products
        </a>
        <a href="{{ route('orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('orders.*') ? 'bg-gray-700' : '' }}">
            Orders
        </a>
        @role('admin')
        <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('suppliers.*') ? 'bg-gray-700' : '' }}">
            Suppliers
        </a>
        <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('customers.*') ? 'bg-gray-700' : '' }}">
            Customers
        </a>
        <a href="{{ route('log') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Logs
        </a>
        @endrole
    </nav>
</div>