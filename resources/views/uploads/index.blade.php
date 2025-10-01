{{-- resources/views/uploads/index.blade.php --}}
<x-user-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">My Uploads</h2>
      <a href="{{ route('uploads.create') }}"
         class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 hover:shadow-lg hover:scale-105">
        + Send New File
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($batches->isEmpty())
      <div class="bg-white shadow-lg rounded-2xl p-12 text-center animate-fade-in">
        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        <p class="text-gray-600 text-lg">You haven't uploaded any files yet.</p>
        <a href="{{ route('uploads.create') }}"
           class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300">
          Upload Your First File
        </a>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($batches as $index => $batch)
          @php
            $report = isset($reportsMap) ? ($reportsMap[$batch->id] ?? null) : null;
          @endphp
          
          <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden card-animate"
               style="animation-delay: {{ $index * 0.1 }}s">
            
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium opacity-90">Batch #{{ $batch->id }}</span>
                @if($batch->urgency === 'urgent')
                  <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full animate-pulse">
                    Urgent
                  </span>
                @else
                  <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                    Normal
                  </span>
                @endif
              </div>
              <p class="text-sm opacity-90">
                {{ $batch->created_at->format('M d, Y • h:i A') }}
              </p>
            </div>

            {{-- Card Body --}}
            <div class="p-6 space-y-4">
              
              {{-- File Type --}}
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">
                    {{ optional($batch->fileType)->name ?? 'Unknown Type' }}
                  </p>
                  @if($batch->fileType && !empty($batch->fileType->anatomy))
                    <p class="text-xs text-gray-500">{{ $batch->fileType->anatomy }}</p>
                  @endif
                </div>
              </div>

              {{-- Price --}}
              <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                <span class="text-sm text-gray-600">Price</span>
                <span class="text-lg font-bold text-gray-900">
                  @if($batch->fileType)
                    {{ number_format($batch->fileType->price_per_file, 2) }} <span class="text-sm font-normal">birr</span>
                  @else
                    —
                  @endif
                </span>
              </div>

              {{-- Delivery Time --}}
              <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                  @if($batch->urgency === 'urgent')
                    Delivery in 4 hours
                  @else
                    Delivery in 24 hours
                  @endif
                </span>
              </div>

              {{-- Report Section --}}
              @if($report)
                <div class="pt-4 border-t border-gray-200">
                  <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Report Available</p>
                  @if($report->pdf_path)
                    <a href="{{ Storage::url($report->pdf_path) }}" target="_blank"
                       class="flex items-center justify-center space-x-2 w-full px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-all duration-300">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                      <span class="font-medium">View PDF Report</span>
                    </a>
                  @else
                    <div class="bg-gray-50 rounded-lg p-3">
                      <p class="text-sm text-gray-700 mb-2">{{ \Illuminate\Support\Str::limit($report->notes, 100) }}</p>
                      <button
                        onclick="showReportModal({{ json_encode($report->notes) }}, {{ $batch->id }})"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium hover:underline">
                        Read full notes →
                      </button>
                    </div>
                  @endif
                </div>
              @endif
            </div>

            {{-- Card Footer --}}
            <div class="px-6 pb-6">
              @if(!is_null($batch->quoted_price))
                @if($batch->paid == 1)
                  <button type="button"
                          class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-lg cursor-not-allowed flex items-center justify-center space-x-2"
                          disabled>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">Paid</span>
                  </button>
                @else
                  <a href="{{ route('uploads.pay.form', $batch->id) }}"
                     class="block w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white text-center rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 hover:shadow-lg hover:scale-105 font-medium">
                    Pay Now
                  </a>
                @endif
              @else
                <div class="text-center py-3 text-gray-400 text-sm">
                  Awaiting quote
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- Modal for Report Notes --}}
  <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 modal-content">
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-semibold">Report Notes</h3>
          <button onclick="closeReportModal()" class="text-white hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
      <div class="p-6 overflow-y-auto max-h-[60vh]">
        <p id="modalContent" class="text-gray-700 whitespace-pre-wrap leading-relaxed"></p>
      </div>
    </div>
  </div>

  <style>
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fade-in 0.6s ease-out;
    }

    .card-animate {
      opacity: 0;
      animation: fade-in 0.6s ease-out forwards;
    }

    .modal-content {
      animation: modal-pop 0.3s ease-out;
    }

    @keyframes modal-pop {
      from {
        transform: scale(0.9);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    /* Smooth hover effects */
    .card-animate:hover {
      transform: translateY(-4px);
    }
  </style>

  <script>
    function showReportModal(notes, batchId) {
      const modal = document.getElementById('reportModal');
      const content = document.getElementById('modalContent');
      content.textContent = notes;
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
      const modal = document.getElementById('reportModal');
      modal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    // Close modal on outside click
    document.getElementById('reportModal')?.addEventListener('click', function(e) {
      if (e.target === this) {
        closeReportModal();
      }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeReportModal();
      }
    });
  </script>
</x-user-app-layout>
