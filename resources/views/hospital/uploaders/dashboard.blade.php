{{-- resources/views/hospital/uploaders/dashboard.blade.php --}}
<x-up-lay>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">My Uploads</h2>
        <p class="text-sm text-gray-600 mt-1">Manage and track your upload batches</p>
      </div>
      <a href="/uploader/uploads/create" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Send New
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Total Uploads Count Box -->
    <div class="mb-8">
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300 animate-fade-in max-w-xs">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-700 text-sm font-medium">Total Uploads</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $batches->count() }}</p>
          </div>
          <div class="bg-blue-600 rounded-full p-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Converted table to card-based layout -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      @if($batches->isEmpty())
        <div class="p-12 text-center">
          <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <p class="text-gray-600 mb-4">No uploads yet.</p>
          <a href="{{ route('uploader.uploads.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Upload now
          </a>
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
          @foreach($batches as $index => $batch)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 animate-fade-in" style="animation-delay: {{ $index * 0.05 }}s;">
              <!-- Card Header -->
              <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white">
                <div class="flex items-center justify-between mb-2">
                  <h3 class="font-semibold text-lg">Batch #{{ $batch->id }}</h3>
                  @if($batch->urgency==='urgent')
                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">
                      Urgent
                    </span>
                  @else
                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                      Normal
                    </span>
                  @endif
                </div>
                <p class="text-sm text-blue-100">{{ $batch->created_at->format('M d, Y • H:i') }}</p>
              </div>

              <!-- Card Body -->
              <div class="p-4 space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 text-sm">Type:</span>
                  <span class="font-medium text-gray-900">{{ optional($batch->fileType)->name ?? '—' }}</span>
                </div>

                <div class="flex justify-between items-center">
                  <span class="text-gray-600 text-sm">Status:</span>
                  <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                    {{ ucfirst($batch->status) }}
                  </span>
                </div>

                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                  <span class="text-gray-600 text-sm">Quote:</span>
                  <span class="font-semibold text-blue-600">
                    @if(is_null($batch->quoted_price))
                      <span class="text-gray-500">TBD</span>
                    @else
                      {{ number_format($batch->quoted_price, 2) }} birr
                    @endif
                  </span>
                </div>
              </div>

              <!-- Card Footer -->
              <div class="bg-gray-50 p-4 border-t border-gray-200">
                @php
                  $report = $reportsMap->get($batch->id);
                @endphp

                @if($report)
                  @if(!empty($report->pdf_path))
                    <a href="{{ Storage::url($report->pdf_path) }}"
                       class="w-full block text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                       target="_blank" rel="noopener">
                      View PDF Report
                    </a>
                  @else
                    <div>
                      <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($report->notes, 80) }}</p>
                      <button
                        onclick="showReportModal({{ json_encode($report->notes) }})"
                        class="w-full text-sm text-blue-600 hover:text-blue-700 font-medium hover:underline py-1">
                        Read full notes →
                      </button>
                    </div>
                  @endif
                @else
                  <span class="text-gray-500 text-sm">No report available</span>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <!-- Modal for Report Notes -->
  <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-96 overflow-y-auto animate-scale-in">
      <div class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Report Notes</h3>
          <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <p id="reportContent" class="text-gray-700 text-sm leading-relaxed"></p>
      </div>
    </div>
  </div>

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

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.5s ease-out forwards;
      opacity: 0;
    }

    .animate-scale-in {
      animation: scaleIn 0.3s ease-out;
    }

    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>

  <script>
    function showReportModal(notes) {
      document.getElementById('reportContent').textContent = notes;
      document.getElementById('reportModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
      document.getElementById('reportModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('reportModal')?.addEventListener('click', function(event) {
      if (event.target === this) {
        closeReportModal();
      }
    });
  </script>
</x-up-lay>
