<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">Uploader: {{ $uploader->name }}</h2>
      <a href="{{ route('hospital.uploaders.index') }}"
         class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
        ← Back to List
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
    {{-- Uploader info --}}
    <div class="bg-white shadow rounded p-6 mb-6">
      <p><strong>Name:</strong> {{ $uploader->name }}</p>
      <p><strong>Email:</strong> {{ $uploader->email }}</p>
      <p><strong>Joined:</strong> {{ $uploader->created_at->format('Y-m-d H:i') }}</p>
    </div>

    {{-- Uploaded Batches --}}
    <div class="bg-white shadow rounded p-6">
      <h3 class="text-lg font-medium mb-4">Uploaded Batches</h3>

      @if($batches->isEmpty())
        <p class="text-gray-600">This uploader has not sent any batches yet.</p>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Batch ID</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Urgency</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ZIP</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Report</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($batches as $batch)
              <tr>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $batch->id }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  {{ $batch->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-4 py-2 text-sm">
                  @if($batch->urgency==='urgent')
                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                      Urgent
                    </span>
                  @else
                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                      Normal
                    </span>
                  @endif
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  {{ optional($batch->fileType)->name ?? '—' }}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($batch->status) }}</td>
                <td class="px-4 py-2 text-sm">
                  <a href="{{ Storage::url($batch->zip_path) }}" download
                     class="text-blue-600 hover:underline">
                    Download ZIP
                  </a>
                </td>
                <td class="px-4 py-2 text-sm">
                  @php
                    // grab the first assignment's report if present
                    $report = $batch->assignments->first()?->report;
                  @endphp

                  @if($report)
                    <a href="{{ Storage::url($report->pdf_path) }}" target="_blank"
                       class="text-blue-600 hover:underline">
                      View PDF
                    </a>
                  @else
                    <span class="text-gray-500">No report</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</x-app-layout>
