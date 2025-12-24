{{-- resources/views/admin/hospitals/all.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <div class="bg-blue-500 p-2 rounded-lg shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">All Hospital Uploads</h1>
          <p class="text-sm text-gray-500">Review every ZIP batch sent by registered hospitals</p>
        </div>
      </div>
      <a href="{{ route('admin.hospitals.index') }}"
         class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 hover:shadow-lg transition-all duration-200 text-center">
        Back to Hospitals
      </a>
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
        @if($uploads->isEmpty())
          {{-- Empty State --}}
          <div class="text-center py-16 px-4">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hospital uploads found</h3>
            <p class="text-gray-500">Hospitals haven't sent any DICOM ZIP batches yet.</p>
          </div>
        @else
          {{-- Desktop Table View --}}
          <div class="hidden lg:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hospital</th>
                  {{-- <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Uploader</th> --}}
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Batch ID</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Uploaded At</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Urgency</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">History</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Report</th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($uploads as $u)
                  @php
                    $batchId = $u->id;
                    $report = $u->assignments->first()?->report;
                  @endphp
                  <tr class="hover:bg-blue-50 transition-colors duration-200 animate-fade-in">
                    {{-- Hospital --}}
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                      {{ optional($u->hospital->user)->name ?? '—' }}
                    </td>

                    {{-- Uploader --}}
                    {{-- <td class="px-6 py-4 text-sm text-gray-700">
                      {{ $u->uploader->name }}
                    </td> --}}

                    {{-- Batch ID --}}
                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                      {{ $batchId }}
                    </td>

                    {{-- Uploaded At --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ $u->created_at->format('Y-m-d H:i') }}
                    </td>

                    {{-- Urgency --}}
                    <td class="px-6 py-4 text-sm">
                      @if($u->urgency === 'urgent')
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">
                          Urgent
                        </span>
                      @else
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                          Normal
                        </span>
                      @endif
                    </td>

                    {{-- Clinical History --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      <span title="{{ $u->clinical_history }}">
                        {{ Str::limit($u->clinical_history, 30) ?: '—' }}
                      </span>
                    </td>

                    {{-- File Type --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($u->fileType)->name ?? '—' }}
                    </td>

                    {{-- Price --}}
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                      @if(is_null($u->quoted_price))
                        <span class="text-gray-500">TBD</span>
                      @else
                        {{ number_format($u->quoted_price, 2) }} birr
                      @endif
                    </td>

                    {{-- Report --}}
                    <td class="px-6 py-4 text-sm">
                      @if($report)
                        <a href="{{ Storage::url($report->pdf_path) }}" target="_blank"
                           class="text-blue-600 font-medium hover:text-blue-800 hover:underline transition-colors duration-200">
                          View
                        </a>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-center">
                      <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.assign.reader', ['batch_no' => $u->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Assign
                        </a>
                        <a href="{{ route('admin.assignments.download', ['batch_no' => $u->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Download
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
            @foreach($uploads as $u)
              @php
                $batchId = $u->id;
                $report = $u->assignments->first()?->report;
              @endphp
              <div class="p-4 hover:bg-gray-50 transition-colors duration-200 animate-fade-in">
                {{-- Card Header --}}
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                  <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900">{{ optional($u->hospital->user)->name ?? '—' }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Batch: {{ $batchId }}</p>
                  </div>
                  @if($u->urgency === 'urgent')
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ml-2">
                      Urgent
                    </span>
                  @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-2">
                      Normal
                    </span>
                  @endif
                </div>

                {{-- Card Content --}}
                <div class="space-y-3 mb-4">
                  <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Uploader</p>
                    <p class="text-sm font-medium text-gray-900">{{ $u->uploader->name }}</p>
                  </div>

                  <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Uploaded At</p>
                    <p class="text-sm text-gray-700">{{ $u->created_at->format('Y-m-d H:i') }}</p>
                  </div>

                  <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">File Type</p>
                    <p class="text-sm text-gray-700">{{ optional($u->fileType)->name ?? '—' }}</p>
                  </div>

                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Price</p>
                      @if(is_null($u->quoted_price))
                        <p class="text-sm font-semibold text-gray-500">TBD</p>
                      @else
                        <p class="text-sm font-semibold text-gray-900">{{ number_format($u->quoted_price, 2) }} birr</p>
                      @endif
                    </div>
                    <div>
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Report</p>
                      @if($report)
                        <a href="{{ Storage::url($report->pdf_path) }}" target="_blank"
                           class="text-sm text-blue-600 font-medium hover:text-blue-800">
                          View
                        </a>
                      @else
                        <p class="text-sm text-gray-400">—</p>
                      @endif
                    </div>
                  </div>

                  @if($u->clinical_history)
                    <div>
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Clinical History</p>
                      <p class="text-sm text-gray-700">{{ Str::limit($u->clinical_history, 60) }}</p>
                    </div>
                  @endif
                </div>

                {{-- Card Actions --}}
                <div class="pt-4 border-t border-gray-200 flex gap-2">
                  <a href="{{ route('admin.assign.reader', ['batch_no' => $u->id]) }}"
                     class="flex-1 px-3 py-2 bg-indigo-600 text-white font-medium text-center text-sm rounded-lg hover:bg-indigo-700 transition-all duration-200 active:scale-95">
                    Assign
                  </a>
                  <a href="{{ route('admin.assignments.download', ['batch_no' => $u->id]) }}"
                     class="flex-1 px-3 py-2 bg-blue-600 text-white font-medium text-center text-sm rounded-lg hover:bg-blue-700 transition-all duration-200 active:scale-95">
                    Download
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
