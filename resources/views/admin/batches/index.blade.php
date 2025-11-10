{{-- resources/views/admin/batches/index.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">All Batches</h2>
      <span class="text-sm text-gray-500">Showing {{ $batches->count() }} batches</span>
    </div>
  </x-slot>

  <div class="flex h-full">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r hidden md:block">
      @include('admin.sidebar')
    </aside>

    {{-- Main content --}}
    <main class="flex-1 p-6">
      <div class="bg-white shadow rounded p-6">
        @if($batches->isEmpty())
          <p class="text-gray-600">No batches found.</p>
        @else
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File type</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploader Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Files</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                  <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($batches as $batch)
                  @php
                    // safe access helpers
                    $fileType = $batch->fileType ?? null;
                    $uploader = $batch->uploader ?? $batch->user ?? null;
                    // files count (use eager count if available)
                    $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0);
                  @endphp

                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 break-words">{{ $batch->id }}</td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if($fileType && $fileType->name)
                        {{ $fileType->name }}
                        @if(!empty($fileType->anatomy))
                          <span class="text-xs text-gray-500">({{ $fileType->anatomy }})</span>
                        @endif
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700 break-words">
                      {{ optional($uploader)->email ?? '—' }}
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ $filesCount }} {{ $filesCount == 1 ? 'file' : 'files' }}
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if(is_null($batch->quoted_price))
                        <span class="text-gray-500">TBD</span>
                      @else
                        {{ number_format($batch->quoted_price, 2) }} birr
                      @endif
                    </td>

                    <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
                      {{-- Assign: go to assign form (adjust route name if needed) --}}
                      {{-- <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                         class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Assign
                      </a> --}}

                      {{-- Download ZIP --}}
                      <a href="{{ route('admin.batches.download', $batch) }}"
                                               class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Download
                                            </a>

                      {{-- Set price / Quote --}}
                      <a href="{{ route('admin.batches.quote.edit', $batch) }}"
                         class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                        Set Price
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
</x-admin-lay>
