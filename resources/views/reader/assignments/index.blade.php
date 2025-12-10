{{-- resources/views/reader/assignments/index.blade.php --}}
<x-read-lay>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-900">My Assignments</h2>
  </x-slot>

  <div class="flex">
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          @if($items->isEmpty())
            <div class="text-center py-16 animate-fade-in">
              <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p class="text-gray-500 text-lg">No assigned batches yet.</p>
            </div>
          @else
            <!-- Desktop View: Table -->
            <div class="hidden lg:block overflow-x-auto">
              <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Batch</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Source / Uploader</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Files</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Assigned</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Deadline</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Overdue</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($items as $it)
                    <tr class="hover:bg-blue-50 transition-colors duration-200 animate-fade-in">
                      <td class="px-6 py-4 text-sm">
                        <div class="font-semibold text-gray-900">{{ $it->batch_id ?? '—' }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ ($it->type ?? '') === 'hospital' ? 'Hospital ZIP' : 'Customer batch' }}</div>
                      </td>
                      <td class="px-6 py-4 text-sm">
                        @if(!empty($it->uploader))
                          <div class="font-medium text-gray-900">{{ $it->uploader->name ?? $it->uploader->email }}</div>
                          @if(!empty($it->uploader->email))
                            <div class="text-xs text-gray-500 mt-1">{{ $it->uploader->email }}</div>
                          @endif
                        @else
                          <span class="text-gray-400">—</span>
                        @endif
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $it->assignments_count ?? '—' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $it->assigned_at ?? '-' }}</td>
                      <td class="px-6 py-4 text-sm text-gray-700">{{ $it->deadline ?? '-' }}</td>
                      <td class="px-6 py-4 text-sm">
                        @php
                          $deadline = $it->deadline ? \Illuminate\Support\Carbon::parse($it->deadline) : null;
                          $isOverdue = $deadline && now()->greaterThan($deadline) && !in_array($it->status, ['done','completed']);
                        @endphp
                        @if($isOverdue)
                          <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">Overdue</span>
                        @else
                          <span class="text-gray-400">—</span>
                        @endif
                      </td>
                      <td class="px-6 py-4 text-sm">
                        @php $status = $it->status ?? 'unknown'; @endphp
                        @if(in_array($status, ['pending','unread']))
                          <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($status === 'in_progress')
                          <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                        @elseif(in_array($status, ['done','completed']))
                          <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        @else
                          <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($status) }}</span>
                        @endif
                      </td>
                      <td class="px-6 py-4 text-center">
                        @if(!empty($it->batch_id))
                          <div class="flex gap-2 justify-center">
                            <a href="{{ route('reader.assignments.download', ['batch_no' => $it->batch_id]) }}"
                               class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                              Download
                            </a>
                            <a href="{{ route('reader.assignments.report.create', ['batch_no' => $it->batch_id]) }}"
                               class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                              Report
                            </a>
                          </div>
                        @else
                          <span class="text-gray-400">—</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Mobile View: Cards -->
            <div class="lg:hidden divide-y divide-gray-200">
              @foreach($items as $it)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-200 animate-fade-in">
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="font-semibold text-gray-900 text-lg">{{ $it->batch_id ?? '—' }}</h3>
                      <p class="text-xs text-gray-500 mt-1">{{ ($it->type ?? '') === 'hospital' ? 'Hospital ZIP' : 'Customer batch' }}</p>
                    </div>
                    @php $status = $it->status ?? 'unknown'; @endphp
                    @if(in_array($status, ['pending','unread']))
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($status === 'in_progress')
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                    @elseif(in_array($status, ['done','completed']))
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                    @else
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($status) }}</span>
                    @endif
                  </div>

                  <div class="space-y-3 mb-4">
                    @if(!empty($it->uploader))
                      <div class="text-sm">
                        <span class="text-gray-600 font-medium">Uploader:</span>
                        <p class="text-gray-900">{{ $it->uploader->name ?? $it->uploader->email }}</p>
                        @if(!empty($it->uploader->email))
                          <p class="text-xs text-gray-500">{{ $it->uploader->email }}</p>
                        @endif
                      </div>
                    @endif

                    <div class="grid grid-cols-2 gap-3 text-sm">
                      <div>
                        <span class="text-gray-600 font-medium block">Files</span>
                        <p class="text-gray-900">{{ $it->assignments_count ?? '—' }}</p>
                      </div>
                      <div>
                        <span class="text-gray-600 font-medium block">Assigned</span>
                        <p class="text-gray-900 text-xs">{{ $it->assigned_at ?? '-' }}</p>
                      </div>
                      <div>
                        <span class="text-gray-600 font-medium block">Deadline</span>
                        <p class="text-gray-900 text-xs">{{ $it->deadline ?? '-' }}</p>
                      </div>
                      <div>
                        @php
                          $deadline = $it->deadline ? \Illuminate\Support\Carbon::parse($it->deadline) : null;
                          $isOverdue = $deadline && now()->greaterThan($deadline) && !in_array($it->status, ['done','completed']);
                        @endphp
                        <span class="text-gray-600 font-medium block">Status</span>
                        @if($isOverdue)
                          <span class="text-xs font-semibold text-red-800">Overdue</span>
                        @else
                          <span class="text-gray-400 text-xs">—</span>
                        @endif
                      </div>
                    </div>
                  </div>

                  @if(!empty($it->batch_id))
                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                      <a href="{{ route('reader.assignments.download', ['batch_no' => $it->batch_id]) }}"
                         class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 text-center">
                        Download
                      </a>
                      <a href="{{ route('reader.assignments.report.create', ['batch_no' => $it->batch_id]) }}"
                         class="flex-1 px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-all duration-200 text-center">
                        Report
                      </a>
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </main>
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

    .animate-fade-in {
      animation: fadeIn 0.5s ease-out forwards;
    }
  </style>
</x-read-lay>
