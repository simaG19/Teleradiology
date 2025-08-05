{{-- resources/views/hospital/uploaders/dashboard.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">My Uploads</h2>
    <h3><a href="/uploader/uploads/create">Send New</a>
  </x-slot>

  <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      @if($batches->isEmpty())
        <p>No uploads yet. <a href="{{ route('uploader.uploads.create') }}" class="text-blue-600">Upload now</a>.</p>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th>Batch ID</th>
              <th>Uploaded At</th>
              <th>Urgency</th>
              <th>Type</th>
              <th>Status</th>
              <th>Quote</th>
              <th>Report</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($batches as $batch)
              <tr>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $batch->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ $batch->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-6 py-4 text-sm">
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
                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ optional($batch->fileType)->name ?? '—' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ ucfirst($batch->status) }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  @if(is_null($batch->quoted_price))
                    <span class="text-gray-500">TBD</span>
                  @else
                    {{ number_format($batch->quoted_price,2) }} birr
                  @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  @php
                    // find first assignment that has a report
                    $report = $batch->assignments->first()?->report;
                  @endphp

                  @if($report)
                    <a href="{{ Storage::url($report->pdf_path) }}"
                       class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                       target="_blank">
                      View Report
                    </a>
                  @else
                    <span class="text-gray-500">—</span>
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
