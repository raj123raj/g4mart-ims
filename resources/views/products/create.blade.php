
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg">

                <div class="border-b border-gray-200 p-6">
                    <h1 class="text-xl font-bold text-gray-800">
                        Add New Product
                    </h1>
                </div>

                <div class="p-6">

                    <form method="POST" action="{{ route('products.store') }}">

                        @csrf

                        @include('products._form')

                        <div class="mt-6 flex gap-3">

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md">
                                Save Product
                            </button>

                            <a href="{{ route('products.index') }}"
                               class="border border-gray-400 text-gray-700 px-5 py-2 rounded-md">
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
