{{-- resources/views/admin/batches/index.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <h2 class="text-2xl font-bold text-gray-900">All Batches</h2>
      <span class="text-sm font-medium text-gray-600 bg-gray-100 px-4 py-2 rounded-full">
        {{ $batches->count() }} batches
      </span>
    </div>
  </x-slot>

  <div class="flex h-full flex-col md:flex-row gap-0 md:gap-6">
    {{-- Sidebar --}}
    <aside class="w-full md:w-64 bg-white border-b md:border-r border-gray-200 hidden md:block rounded-lg shadow-sm">
      @include('admin.sidebar')
    </aside>

    {{-- Main content --}}
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden animate-fade-in">

        @if($batches->isEmpty())
          {{-- Empty State --}}
          <div class="p-8 sm:p-16 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500 text-lg font-medium">No batches found.</p>
          </div>
        @else
          {{-- Desktop Table View --}}
          <div class="hidden lg:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Batch ID</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">File Type</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Uploaded At</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Uploader</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($batches as $batch)
                  @php
                    $fileType = $batch->fileType ?? null;
                    $uploader = $batch->uploader ?? $batch->user ?? null;
                    $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0);
                  @endphp

                  <tr class="hover:bg-blue-50 transition-colors duration-200 animate-fade-in">
                    {{-- Batch ID --}}
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 break-words">
                      {{ $batch->id }}
                    </td>

                    {{-- File Type --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if($fileType && $fileType->name)
                        <div class="font-medium text-gray-900">{{ $fileType->name }}</div>
                        @if(!empty($fileType->anatomy))
                          <div class="text-xs text-gray-500 mt-1">{{ $fileType->anatomy }}</div>
                        @endif
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>

                    {{-- Uploaded At --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}
                    </td>

                    {{-- Uploader --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if($uploader)
                        <div class="font-medium text-gray-900">{{ $uploader->name ?? '—' }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $uploader->email ?? '—' }}</div>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>

                    {{-- Price --}}
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                      @if(is_null($batch->quoted_price))
                        <span class="text-gray-500">TBD</span>
                      @else
                        {{ number_format($batch->quoted_price, 2) }} birr
                      @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-center text-sm">
                      <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.batches.download', $batch) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Download
                        </a>
                        <a href="{{ route('admin.batches.quote.edit', $batch) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Set Price
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Mobile Card View --}}
          <div class="lg:hidden divide-y divide-gray-200">
            @foreach($batches as $batch)
              @php
                $fileType = $batch->fileType ?? null;
                $uploader = $batch->uploader ?? $batch->user ?? null;
                $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0);
              @endphp

              <div class="p-4 hover:bg-gray-50 transition-colors duration-200 animate-fade-in">
                {{-- Card Header --}}
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                  <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900">{{ $batch->id }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}</p>
                  </div>
                </div>

                {{-- Card Content --}}
                <div class="space-y-3 mb-4">
                  {{-- File Type --}}
                  <div class="flex justify-between items-start">
                    <div>
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-1">File Type</p>
                      @if($fileType && $fileType->name)
                        <p class="text-sm font-medium text-gray-900">{{ $fileType->name }}</p>
                        @if(!empty($fileType->anatomy))
                          <p class="text-xs text-gray-500">{{ $fileType->anatomy }}</p>
                        @endif
                      @else
                        <p class="text-sm text-gray-400">—</p>
                      @endif
                    </div>
                  </div>

                  {{-- Uploader --}}
                  @if($uploader)
                    <div>
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Uploader</p>
                      <p class="text-sm font-medium text-gray-900">{{ $uploader->name ?? '—' }}</p>
                      <p class="text-xs text-gray-500">{{ $uploader->email ?? '—' }}</p>
                    </div>
                  @endif

                  {{-- Price --}}
                  <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Price</p>
                    @if(is_null($batch->quoted_price))
                      <p class="text-sm font-semibold text-gray-500">TBD</p>
                    @else
                      <p class="text-sm font-semibold text-gray-900">{{ number_format($batch->quoted_price, 2) }} birr</p>
                    @endif
                  </div>
                </div>

                {{-- Card Actions --}}
                <div class="pt-4 border-t border-gray-200 flex gap-2">
                  <a href="{{ route('admin.batches.download', $batch) }}"
                     class="flex-1 px-3 py-2 bg-blue-600 text-white font-medium text-center text-sm rounded-lg hover:bg-blue-700 transition-all duration-200 active:scale-95">
                    Download
                  </a>
                  <a href="{{ route('admin.batches.quote.edit', $batch) }}"
                     class="flex-1 px-3 py-2 bg-green-600 text-white font-medium text-center text-sm rounded-lg hover:bg-green-700 transition-all duration-200 active:scale-95">
                    Set Price
                  </a>
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
