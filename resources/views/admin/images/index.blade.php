{{-- resources/views/admin/images/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">All Uploaded DICOM Batches</h2>
    </x-slot>

    <div class="flex h-screen overflow-hidden">
        @include('admin.sidebar')

        <main class="flex-1 bg-gray-100 p-6 overflow-auto">
            @if($batches->isEmpty())
                <p class="text-gray-600">No uploads found.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200 bg-white shadow rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Batch No.
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uploader Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uploader Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                # Files
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uploaded At
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assign
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($batches as $batch)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batch->batch_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batch->uploader->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batch->uploader->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batch->images_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($batch->latest_upload)->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->batch_no]) }}"
   class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
    Assign
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
