
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Heading -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Product Management
                    </h1>
                    <p class="text-gray-600">
                        Add, update, search and remove products.
                    </p>
                </div>

                <a href="{{ route('products.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    + Add Product
                </a>
            </div>

            <!-- Search Form -->
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">

                <form method="GET" action="{{ route('products.index') }}"
                      class="flex gap-2">

                    <input type="search"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Search by product name or SKU"
                           class="flex-1 border-gray-300 rounded-md shadow-sm">

                    <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md">
                        Search
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="border border-gray-400 text-gray-700 px-4 py-2 rounded-md">
                        Clear
                    </a>

                </form>
            </div>

            <!-- Product Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">SKU</th>
                                <th class="p-3">Product</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Price (₹)</th>
                                <th class="p-3">Quantity</th>
                                <th class="p-3">Stock Status</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($products as $product)

                                <tr class="border-t hover:bg-gray-50">

                                    <td class="p-3">
                                        {{ $product->sku }}
                                    </td>

                                    <td class="p-3 font-semibold">
                                        {{ $product->name }}
                                    </td>

                                    <td class="p-3">
                                        {{ $product->category ?: '—' }}
                                    </td>

                                    <td class="p-3">
                                        {{ number_format((float) $product->price, 2) }}
                                    </td>

                                    <td class="p-3">
                                        {{ $product->quantity }}
                                    </td>

                                    <td class="p-3">
                                        @if ($product->is_low_stock)
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">
                                                Low stock
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">
                                                Available
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-right whitespace-nowrap">

                                        <a href="{{ route('products.edit', $product) }}"
                                           class="text-blue-600 hover:text-blue-800 mr-2">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('products.destroy', $product) }}"
                                              class="inline"
                                              onsubmit="return confirm('Delete this product?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="text-center text-gray-500 p-6">
                                        No products found. Add a product or change your search.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $products->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
