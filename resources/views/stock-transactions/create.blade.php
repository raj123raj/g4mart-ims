
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Record Stock Transaction
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h1 class="text-xl font-bold mb-6">
                    Record Stock Transaction
                </h1>

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('stock-transactions.store') }}">

                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Product
                        </label>

                        <select name="product_id"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">Select product</option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    @selected(old('product_id') == $product->id)>
                                    {{ $product->name }}
                                    ({{ $product->sku }})
                                    — Current stock: {{ $product->quantity }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Transaction Type
                        </label>

                        <select name="transaction_type"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="stock_in"
                                @selected(old('transaction_type') == 'stock_in')>
                                Stock In (supplier receipt)
                            </option>

                            <option value="stock_out"
                                @selected(old('transaction_type') == 'stock_out')>
                                Stock Out (sale/issue)
                            </option>

                            <option value="adjustment"
                                @selected(old('transaction_type') == 'adjustment')>
                                Adjustment (set counted stock)
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Quantity
                        </label>

                        <input type="number"
                               name="quantity"
                               min="1"
                               required
                               value="{{ old('quantity') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Reference (optional)
                        </label>

                        <input type="text"
                               name="reference"
                               maxlength="100"
                               value="{{ old('reference') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium mb-2">
                            Notes (optional)
                        </label>

                        <textarea name="notes"
                                  maxlength="1000"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md">
                        Save Transaction
                    </button>

                    <a href="{{ route('stock-transactions.index') }}"
                       class="ml-3 text-gray-600 underline">
                        Cancel
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
