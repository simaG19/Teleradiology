{{-- resources/views/admin/users/clients.blade.php --}}
<x-admin-lay>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Clients</h2>
    </x-slot>

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar (reuse the same partial as before) --}}
        @include('admin.sidebar')

        <main class="flex-1 bg-gray-100 p-6 overflow-auto">
            @if($clients->isEmpty())
                <p class="text-gray-600">No clients found.</p>
            @else
                <div class="bg-white shadow rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clients as $client)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $client->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $client->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $client->email }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </main>
    </div>
</x-admin-lay>
