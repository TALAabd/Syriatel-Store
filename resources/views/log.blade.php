<x-app-layout>
    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 p-8 space-y-8">

            {{-- Page Title --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Order History Report</h1>
            </div>

            {{-- Daily Sales --}}
            <div class="bg-white shadow rounded-lg p-6 border">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Daily Sales</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border text-right">Total Amount ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daily as $d)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $d->date }}</td>
                                <td class="px-4 py-2 border text-right font-medium text-green-600">
                                    ${{ number_format($d->total_amount, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 border text-center text-gray-500">
                                    No daily sales data available.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Monthly Sales --}}
            <div class="bg-white shadow rounded-lg p-6 border">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Monthly Sales</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Month</th>
                                <th class="px-4 py-2 border text-right">Total Amount ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthly as $m)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $m->month }}</td>
                                <td class="px-4 py-2 border text-right font-medium text-blue-600">
                                    ${{ number_format($m->total_amount, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 border text-center text-gray-500">
                                    No monthly sales data available.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Yearly Sales --}}
            <div class="bg-white shadow rounded-lg p-6 border">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Yearly Sales</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Year</th>
                                <th class="px-4 py-2 border text-right">Total Amount ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($yearly as $y)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $y->year }}</td>
                                <td class="px-4 py-2 border text-right font-medium text-indigo-600">
                                    ${{ number_format($y->total_amount, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 border text-center text-gray-500">
                                    No yearly sales data available.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>