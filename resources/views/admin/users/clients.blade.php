{{-- resources/views/admin/users/clients.blade.php --}}
<x-admin-lay>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-500 p-2 rounded-lg shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.5a1.5 1.5 0 01-1.5-1.5V5.5A1.5 1.5 0 013.5 4h17A1.5 1.5 0 0122 5.5v12a1.5 1.5 0 01-1.5 1.5zm0 0h1.5a1.5 1.5 0 001.5-1.5v-5.5a1.5 1.5 0 00-1.5-1.5H15" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Clients</h1>
                    <p class="text-sm text-gray-500">Manage all registered clients and their accounts</p>
                </div>
            </div>
            <span class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 font-semibold rounded-full text-sm">
                {{ $clients->count() }} client{{ $clients->count() != 1 ? 's' : '' }}
            </span>
        </div>
    </x-slot>

    <div class="flex h-full flex-col md:flex-row gap-0 md:gap-6">
        {{-- Sidebar --}}
        <aside class="w-full md:w-64 bg-white border-b md:border-r border-gray-200 hidden md:block rounded-lg shadow-sm">
            @include('admin.sidebar')
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden animate-fade-in">
                @if($clients->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center py-16 px-4">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No clients found</h3>
                        <p class="text-gray-500">There are no registered clients yet.</p>
                    </div>
                @else
                    {{-- Desktop Table View --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($clients as $client)
                                    <tr class="hover:bg-indigo-50 transition-colors duration-200 animate-fade-in">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            #{{ $client->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ substr($client->name, 0, 1) }}
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $client->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $client->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">
                                                Active
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="lg:hidden divide-y divide-gray-200">
                        @foreach($clients as $client)
                            <div class="p-4 hover:bg-indigo-50 transition-colors duration-200 animate-fade-in">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-semibold">
                                            {{ substr($client->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-bold text-gray-900 break-words">{{ $client->name }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">ID: #{{ $client->id }}</p>
                                        </div>
                                    </div>
                                    <span class="ml-2 px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs whitespace-nowrap">
                                        Active
                                    </span>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Email</p>
                                    <p class="text-sm text-gray-700 break-all">{{ $client->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>

    {{-- Animations --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-admin-lay>
