{{-- resources/views/admin/users/readers.blade.php --}}
</x-admin-lay>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Readers</h2>
    </x-slot>

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @include('admin.sidebar')

        <main class="flex-1 bg-gray-100 p-6 overflow-auto">
            <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-medium">Readers</h2>
    <a href="{{ route('admin.users.readers.create') }}"
       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        <!-- Plus icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v16m8-8H4" />
        </svg>
        Add Reader
    </a>
</div>



            @if($readers->isEmpty())
                <p class="text-gray-600">No readers found.</p>
            @else
                <div class="bg-white shadow rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- ID --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #
                                </th>
                                {{-- Name --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                {{-- Email --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                {{-- Assigned Files --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assigned Files
                                </th>
                                {{-- Reported --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reported
                                </th>
                                {{-- Unread & Assigned --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unread Assigned
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($readers as $reader)
                                <tr>
                                    {{-- ID --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->id }}
                                    </td>
                                    {{-- Name --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->name }}
                                    </td>
                                    {{-- Email --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->email }}
                                    </td>
                                    {{-- Assigned Files --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->assigned_count }}
                                    </td>
                                    {{-- Reported --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->reported_count }}
                                    </td>
                                    {{-- Unread & Assigned --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reader->unread_count }}
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
