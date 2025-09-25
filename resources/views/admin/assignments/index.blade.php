{{-- resources/views/admin/assignments/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold">Assignment Management</h2>
        <p class="text-sm text-gray-500">Monitor and manage assigned radiology batches</p>
      </div>
      <div class="flex items-center space-x-3">
        <a href="{{ route('admin.images.index') }}"
           class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
          All Batches
        </a>
        <a href="{{ route('admin.assignments.index') }}"
           class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm">
          Assignments
        </a>
      </div>
    </div>
  </x-slot>

  <div class="flex h-screen overflow-hidden bg-gray-50">
    {{-- Sidebar --}}
    @include('admin.sidebar')

    <main class="flex-1 overflow-auto">
      <div class="p-6 max-w-7xl mx-auto">
        {{-- summary cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
          <div class="bg-white rounded shadow p-4">
            <div class="text-xs text-gray-500">Total Batches (represented)</div>
            <div class="text-2xl font-semibold">{{ $assignments->count() }}</div>
          </div>
          <div class="bg-white rounded shadow p-4">
            <div class="text-xs text-gray-500">Pending</div>
            <div class="text-2xl font-semibold">
              {{ $assignments->filter(fn($a) => ($a->status ?? '') === 'pending' || ($a->status ?? '') === 'unread')->count() }}
            </div>
          </div>
          <div class="bg-white rounded shadow p-4">
            <div class="text-xs text-gray-500">Completed</div>
            <div class="text-2xl font-semibold">
              {{ $assignments->filter(fn($a) => ($a->status ?? '') === 'completed' || ($a->status ?? '') === 'done')->count() }}
            </div>
          </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
          <div class="px-6 py-4 border-b">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-medium text-gray-900">Active Assignments</h3>
              <span class="text-sm text-gray-500">Showing one row per batch/upload</span>
            </div>
          </div>

          {{-- table --}}
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch / Upload</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Source</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploader</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned By</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reader</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned At</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deadline</th>
                  <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
              </thead>

              <tbody class="bg-white divide-y divide-gray-200">
                @forelse($assignments as $assignment)
                  @php
                    // determine the logical batch identifier and source type
                    $batchIdentifier = null;
                    $sourceType = 'Unknown';
                    $uploaderName = null;
                    $uploaderEmail = null;
                    $fileCount = null;

                    if (!empty($assignment->image) && !empty($assignment->image->batch_no)) {
                      $batchIdentifier = $assignment->image->batch_no;
                      $sourceType = 'Customer (images)';
                      $uploaderName = optional($assignment->image->uploader)->name;
                      $uploaderEmail = optional($assignment->image->uploader)->email;
                      // file count unknown here unless you eager-loaded; show "—" if not set
                    } elseif (!empty($assignment->batch_id) && !empty($assignment->batch)) {
                      $batchIdentifier = $assignment->batch->id;
                      $sourceType = 'Customer (batch)';
                      $uploaderName = optional($assignment->batch->uploader)->name;
                      $uploaderEmail = optional($assignment->batch->uploader)->email;
                      // if Batch has images_count relationship you can show it
                    } elseif (!empty($assignment->hospital_upload_id) && !empty($assignment->hospitalUpload)) {
                      $batchIdentifier = $assignment->hospitalUpload->id;
                      $sourceType = 'Hospital (ZIP)';
                      $uploaderName = optional($assignment->hospitalUpload->uploader)->name;
                      $uploaderEmail = optional($assignment->hospitalUpload->uploader)->email;
                      $fileCount = $assignment->hospitalUpload->file_count ?? null;
                    }

                    // status/labels
                    $status = $assignment->status ?? 'pending';
                    $statusBadge = match($status) {
                      'pending', 'unread' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'],
                      'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'In Progress'],
                      'completed', 'done' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Completed'],
                      default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => ucfirst($status)],
                    };
                  @endphp

                  <tr class="hover:bg-gray-50">
                    {{-- Batch / Upload --}}
                    <td class="px-6 py-4">
                      <div class="text-sm font-medium text-gray-900">{{ $batchIdentifier ?? '—' }}</div>
                      <div class="text-xs text-gray-500">{{ $sourceType }}</div>
                      @if($fileCount)
                        <div class="text-xs text-gray-400 mt-1">{{ $fileCount }} file{{ $fileCount>1 ? 's':'' }}</div>
                      @endif
                    </td>

                    {{-- Source (Hospital name or N/A) --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if(!empty($assignment->hospitalUpload) && !empty($assignment->hospitalUpload->hospital))
                        {{ optional($assignment->hospitalUpload->hospital)->hospital_name }}
                      @elseif(!empty($assignment->batch) && !empty($assignment->batch->hospital))
                        {{ optional($assignment->batch->hospital)->hospital_name }}
                      @else
                        <span class="text-gray-500">—</span>
                      @endif
                    </td>

                    {{-- Uploader --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if($uploaderName || $uploaderEmail)
                        <div class="font-medium">{{ $uploaderName ?? '—' }}</div>
                        <div class="text-xs text-gray-500">{{ $uploaderEmail ?? '—' }}</div>
                      @else
                        <span class="text-gray-500">—</span>
                      @endif
                    </td>

                    {{-- Assigned by --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($assignment->assignedBy)->name ?? optional($assignment->assignedBy)->email ?? '—' }}
                    </td>

                    {{-- Reader --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($assignment->assignedTo)->name ?? optional($assignment->assignedTo)->email ?? '—' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4 text-sm">
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['bg'] }} {{ $statusBadge['text'] }}">
                        {{ $statusBadge['label'] }}
                      </span>
                    </td>

                    {{-- Assigned at --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ optional($assignment->assigned_at ?? $assignment->created_at)->format('Y-m-d H:i') ?? '—' }}
                    </td>

                    {{-- Deadline --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      @if(!empty($assignment->deadline))
                        {{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d H:i') }}
                        @php
                          $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($assignment->deadline)) && !in_array($status, ['completed','done']);
                        @endphp
                        @if($isOverdue)
                          <div class="text-xs text-red-600 font-semibold mt-1">OVERDUE</div>
                        @endif
                      @else
                        <span class="text-gray-500">—</span>
                      @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-center">
                      <div class="flex items-center justify-center space-x-2">
                        {{-- Download original ZIP (if batch id exists) --}}
                        @if($batchIdentifier)
                          {{-- <a href="{{ route('admin.assignments.download', $batchIdentifier) }}"
                             class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                             title="Download original ZIP / files">
                            Download
                          </a> --}}
                        @else
                          <button disabled class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-500 rounded text-sm">Download</button>
                        @endif

                        {{-- Report (if any) --}}
                        @php
                          $report = $assignment->report ?? ($assignment->hospitalUpload->report ?? null ?? null);
                        @endphp

                        @if(!empty($assignment->report) || (!empty($assignment->hospitalUpload) && !empty($assignment->hospitalUpload->report)))
                          @php
                            // prefer assignment->report, else hospitalUpload->report
                            $r = $assignment->report ?? ($assignment->hospitalUpload->report ?? null);
                          @endphp
                          @if(!empty($r) && !empty($r->pdf_path))
                            <a href="{{ Storage::url($r->pdf_path) }}" target="_blank"
                               class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                              View Report
                            </a>
                          @else
                            <span class="text-gray-500 text-sm">No report</span>
                          @endif
                        @else
                          <span class="text-gray-500 text-sm">No report</span>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td class="px-6 py-6 text-center text-gray-500" colspan="9">
                      No assignments found.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div> {{-- bg-white --}}
      </div>
    </main>
  </div>
</x-app-layout>
