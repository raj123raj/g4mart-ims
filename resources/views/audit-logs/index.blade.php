
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Audit Logs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Heading -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Audit Logs
                </h1>

                <p class="text-gray-600">
                    Monitor user activities and changes made in G4Mart.
                </p>
            </div>

            <!-- Filter Form -->
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">

                <form method="GET"
                      action="{{ route('audit-logs.index') }}"
                      class="flex flex-wrap items-end gap-3">

                    <div class="flex-1 min-w-48">
                        <label for="action"
                               class="block font-medium text-gray-700 mb-2">
                            Filter Action
                        </label>

                        <input type="text"
                               id="action"
                               name="action"
                               value="{{ request('action') }}"
                               placeholder="e.g. product.updated"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md">
                        Filter
                    </button>

                    <a href="{{ route('audit-logs.index') }}"
                       class="border border-gray-400 text-gray-700 px-4 py-2 rounded-md">
                        Clear
                    </a>

                </form>

            </div>

            <!-- Audit Log Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Date / Time</th>
                                <th class="p-3">User</th>
                                <th class="p-3">Action</th>
                                <th class="p-3">Record</th>
                                <th class="p-3">Old Values</th>
                                <th class="p-3">New Values</th>
                                <th class="p-3">IP Address</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($logs as $log)

                                <tr class="border-t hover:bg-gray-50">

                                    <td class="p-3 whitespace-nowrap">
                                        {{ $log->created_at?->format('d-m-Y H:i:s') }}
                                    </td>

                                    <td class="p-3">
                                        {{ $log->user?->name ?? 'System/Deleted user' }}
                                    </td>

                                    <td class="p-3">
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm">
                                            {{ $log->action }}
                                        </span>
                                    </td>

                                    <td class="p-3">
                                        {{ class_basename($log->auditable_type ?? '') }}
                                        #{{ $log->auditable_id }}
                                    </td>

                                    <td class="p-3 text-sm">
                                        <pre class="whitespace-pre-wrap break-all text-xs">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>

                                    <td class="p-3 text-sm">
                                        <pre class="whitespace-pre-wrap break-all text-xs">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>

                                    <td class="p-3">
                                        {{ $log->ip_address }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="text-center text-gray-500 p-6">
                                        No audit entries found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $logs->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
