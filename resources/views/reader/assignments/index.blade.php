{{-- resources/views/reader/assignments/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">My Assignments</h2>
  </x-slot>

  <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      @if($items->isEmpty())
        <div class="text-center py-12">
          <p class="text-gray-500">No assigned batches yet.</p>
        </div>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Source / Uploader</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Files</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deadline</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($items as $it)
              <tr>
                <td class="px-6 py-4 text-sm text-gray-700">
                  <div class="font-medium">{{ $it->batch_no }}</div>
                  <div class="text-xs text-gray-400">{{ $it->type === 'hospital' ? 'Hospital ZIP' : 'Customer batch' }}</div>
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                  @if($it->uploader)
                    <div>{{ $it->uploader->name ?? $it->uploader->email }}</div>
                    <div class="text-xs text-gray-400">{{ $it->uploader->email }}</div>
                  @else
                    <span class="text-gray-400">—</span>
                  @endif
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ $it->files_count ?? '—' }}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ optional($it->assigned_at)->format('Y-m-d H:i') ?? '-' }}
                </td>

                <td class="px-6 py-4 text-sm">
                  {{ optional($it->deadline)->format('Y-m-d H:i') ?? '-' }}
                </td>

                <td class="px-6 py-4 text-sm">
                  @if($it->status === 'pending' || $it->status === 'unread')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                  @elseif($it->status === 'in_progress')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                  @elseif($it->status === 'done' || $it->status === 'completed')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                  @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($it->status) }}</span>
                  @endif
                </td>

                <td class="px-6 py-4 text-center">
                  <a href="{{ route('reader.assignments.download', $it->batch_no) }}"
                     class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Download
                  </a>

                  {{-- If you want a "View" link to see the list of images / details, add one here --}}
                </td>

                <td class="px-6 py-4 text-center">
                  <a href="{{ route('reader.assignments.report.create', $it->batch_no) }}"
                     class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                   Create Report
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</x-app-layout>
