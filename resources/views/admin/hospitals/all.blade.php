{{-- resources/views/admin/hospitals/all.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="bg-blue-500 p-2 rounded-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 7h18M3 12h18M3 17h18" />
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">All Hospital Uploads</h1>
              <p class="text-sm text-gray-500">Review every ZIP batch sent by registered hospitals</p>
            </div>
          </div>
          <a href="{{ route('admin.hospitals.index') }}"
             class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Back to Hospitals
          </a>
        </div>
      </div>
    </div>
  </x-slot>

  <div class="flex h-screen overflow-hidden bg-gray-50">
    @include('admin.sidebar')

    <main class="flex-1 overflow-auto">
      <div class="p-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          @if($uploads->isEmpty())
            <div class="text-center py-16">
              <h3 class="text-lg font-medium text-gray-900 mb-2">No hospital uploads found</h3>
              <p class="text-gray-500">Hospitals haven’t sent any DICOM ZIP batches yet.</p>
            </div>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hospital</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploader</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urgency</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">History</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Report</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($uploads as $u)
                    @php
                      $batchId = $u->id;
                      $report  = $u->assignments->first()?->report;
                    @endphp
                    <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $u->hospital->hospital_name }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $u->uploader->name }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $batchId }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $u->created_at->format('Y-m-d H:i') }}</td>
                      <td class="px-6 py-4 text-sm">
                        @if($u->urgency === 'urgent')
                          <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Urgent
                          </span>
                        @else
                          <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Normal
                          </span>
                        @endif
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($u->clinical_history, 30) ?: '—' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ optional($u->fileType)->name ?? '—' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">
                        @if(is_null($u->quoted_price))
                          <span class="text-gray-500">TBD</span>
                        @else
                          {{ number_format($u->quoted_price,2) }} birr
                        @endif
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-700">
                        @if($report)
                          <a href="{{ Storage::url($report->pdf_path) }}" target="_blank"
                             class="text-blue-600 hover:underline">View</a>
                        @else
                          <span class="text-gray-500">—</span>
                        @endif
                      </td>
                      {{-- <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.images.assign', ['batch_no'=>$batchId]) }}"
                           class="inline-flex px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                          Assign
                        </a>
                        <a href="{{ route('admin.assignments.download', ['batch_no'=>$batchId]) }}"
                           class="inline-flex px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                          Download
                        </a>
                      </td> --}}


                <td class="px-4 py-2 text-center space-x-2">
                  {{-- Assign to Reader --}}
          {{-- resources/views/admin/hospitals/all.blade.php --}}
<a href="{{ route('admin.assign.reader', ['batch_no' => $u->id]) }}"
   class="inline-flex px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
  Assign
</a>

                </td>
                <td>

                  {{-- Download ZIP --}}
                  <a href="{{ route('admin.assignments.download', ['batch_no' => $u->id]) }}"
                     class="inline-flex px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
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
      </div>
    </main>
  </div>
</x-admin-lay>


