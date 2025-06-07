<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">My Assigned Batches</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        @if($batches->isEmpty())
          <p>No assignments found.</p>
        @else
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th>Batch No.</th>
                <th>Assigned At</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Download</th>
                <th>Report</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($batches as $batch)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $batch->batch_no }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $batch->assigned_at }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $batch->deadline }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">{{ ucfirst($batch->status) }}</td>

                  {{-- Download ZIP --}}
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <a href="{{ route('reader.assignments.download', ['batch_no' => $batch->batch_no]) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                      Download
                    </a>
                  </td>

                  {{-- Create Report --}}
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <a href="{{ route('reader.assignments.report.create', ['batch_no' => $batch->batch_no]) }}"
                       class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                      Report
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
