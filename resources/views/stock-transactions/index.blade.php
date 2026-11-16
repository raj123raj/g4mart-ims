
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Stock Transactions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1 class="text-xl font-bold mb-4">
                    Stock Transactions
                </h1>

                <p class="mb-4">
                    <a href="{{ route('stock-transactions.create') }}"
                       class="text-blue-600 underline">
                        Record a transaction
                    </a>
                </p>

                @if(session('success'))
                    <p class="text-green-600 mb-4">
                        {{ session('success') }}
                    </p>
                @endif

                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Date</th>
                            <th class="border p-2">Product</th>
                            <th class="border p-2">Type</th>
                            <th class="border p-2">Quantity</th>
                            <th class="border p-2">Before</th>
                            <th class="border p-2">After</th>
                            <th class="border p-2">Performed by</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="border p-2">
                                    {{ $transaction->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="border p-2">
                                    {{ $transaction->product->name }}
                                    ({{ $transaction->product->sku }})
                                </td>

                                <td class="border p-2">
                                    {{ str_replace('_', ' ', ucfirst($transaction->transaction_type)) }}
                                </td>

                                <td class="border p-2">
                                    {{ $transaction->quantity }}
                                </td>

                                <td class="border p-2">
                                    {{ $transaction->quantity_before }}
                                </td>

                                <td class="border p-2">
                                    {{ $transaction->quantity_after }}
                                </td>

                                <td class="border p-2">
                                    {{ $transaction->performer->name ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-3 text-center">
                                    No stock transactions recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
