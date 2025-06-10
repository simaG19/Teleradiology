{{-- resources/views/admin/assignments/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Assigned DICOM Batches</h2>
    </x-slot>

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar (import the partial) --}}
        @include('admin.sidebar')

        {{-- Main content area --}}
        <main class="flex-1 bg-gray-100 p-6 overflow-auto">
            @if($assignments->isEmpty())
                <p class="text-gray-600">No assignments found.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 bg-white shadow rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- ...existing table columns... --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Batch No.
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uploader Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assigned By
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reader Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deadline
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Download
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assignments as $assignment)
                            <tr>
                                {{-- ...existing table cells... --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $assignment->image->batch_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $assignment->image->uploader->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $assignment->assignedBy->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $assignment->assignedTo->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $assignment->status === 'unread' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.assignments.download', $assignment->image->batch_no) }}"
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </main>
    </div>
</x-app-layout>
