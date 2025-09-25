{{-- resources/views/admin/images/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">All Uploaded Batches</h2>
            <span class="text-sm text-gray-500">Showing {{ $batches->count() }} batches</span>
        </div>
    </x-slot>

    <div class="flex h-full">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r hidden md:block">
            @include('admin.sidebar')
        </aside>

        <main class="flex-1 p-6">
            <div class="bg-white shadow rounded-lg p-6">
                @if($batches->isEmpty())
                    <p class="text-gray-600">No batches found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploader</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Files</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urgency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type (Anatomy)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                     <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($batches as $batch)
                                    <tr class="hover:bg-gray-50">
                                        {{-- Batch ID --}}
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $batch->id }}
                                        </td>

                                        {{-- Uploader (guard against null) --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <div class="flex flex-col">
                                                <span class="font-medium">
                                                    {{ optional($batch->uploader)->name ?? optional($batch->user)->name ?? '—' }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ optional($batch->uploader)->email ?? optional($batch->user)->email ?? '—' }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Uploaded At --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}
                                        </td>

                                        {{-- Files count (safe) --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @php
                                                // If you warmed up eager count, use it (images_count); otherwise run relationship count
                                                $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0);
                                            @endphp
                                            {{ $filesCount }} {{ $filesCount == 1 ? 'file' : 'files' }}
                                        </td>

                                        {{-- Urgency --}}
                                        <td class="px-6 py-4 text-sm">
                                            @if(optional($batch)->urgency === 'urgent')
                                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Normal</span>
                                            @endif
                                        </td>

                                        {{-- Type + Anatomy --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @if(optional($batch->fileType)->name)
                                                {{ $batch->fileType->name }}
                                                @if(!empty($batch->fileType->anatomy))
                                                    <span class="text-xs text-gray-500">({{ $batch->fileType->anatomy }})</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>

                                        {{-- Price --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            @if(is_null($batch->quoted_price))
                                                <span class="text-gray-500">TBD</span>
                                            @else
                                                {{ number_format($batch->quoted_price, 2) }} birr
                                            @endif
                                        </td>

                                         <<td class="px-6 py-4 text-sm">
                                            @if(optional($batch)->paid === 0)
                                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Unpaid</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
                                            {{-- Assign (go to assign form) --}}
                                            <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                                               class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                                Assign
                                            </a>

                                            {{-- Download ZIP (batches controller) --}}
                                            <a href="{{ route('admin.batches.download', $batch) }}"
                                               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
