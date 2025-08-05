<x-app-layout>
  <x-slot name="header">
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <div class="bg-blue-500 p-2 rounded-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div>
              <h1 class="text-2xl font-bold text-gray-900">My Assigned Batches</h1>
              <p class="text-sm text-gray-500">Manage your radiology assignments and reports</p>
            </div>
          </div>
          <div class="flex space-x-2">
            <button class="btn btn-outline-primary btn-sm flex items-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              <span>Refresh</span>
            </button>
            <button class="btn btn-outline-secondary btn-sm flex items-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
              </svg>
              <span>Filter</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </x-slot>

  <div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
          $pendingCount = 0;
          $inProgressCount = 0;
          $completedCount = 0;
          $overdueCount = 0;

          foreach($batches as $batch) {
            switch($batch->status) {
              case 'pending': $pendingCount++; break;
              case 'in_progress': $inProgressCount++; break;
              case 'completed': $completedCount++; break;
              case 'overdue': $overdueCount++; break;
            }
          }
        @endphp

        <!-- Pending Card -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-yellow-100 text-sm font-medium">Pending Review</p>
              <p class="text-3xl font-bold">{{ $pendingCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- In Progress Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm font-medium">In Progress</p>
              <p class="text-3xl font-bold">{{ $inProgressCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
              <svg class="w-8 h-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Completed Card -->
        <div class="bg-gradient-to-r from-green-500 to-green-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm font-medium">Completed</p>
              <p class="text-3xl font-bold">{{ $completedCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Overdue Card -->
        <div class="bg-gradient-to-r from-red-500 to-red-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-red-100 text-sm font-medium">Overdue</p>
              <p class="text-3xl font-bold">{{ $overdueCount }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
              Assignment Queue
            </h2>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
              {{ count($batches) }} Total Batches
            </span>
          </div>
        </div>

        @if($batches->isEmpty())
          <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
              <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Assignments Available</h3>
            <p class="text-gray-500 mb-6">You currently have no radiology batches assigned to you.</p>
            <button class="btn btn-primary">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              Check for New Assignments
            </button>
          </div>
        @else
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Batch Information
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Timeline
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                  <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach($batches as $batch)
                  <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                          </svg>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">{{ $batch->batch_no }}</div>
                          <div class="text-sm text-gray-500">Radiology Assignment</div>
                        </div>
                      </div>
                    </td>

                    <td class="px-6 py-4">
                      <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                          <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                          </svg>
                          <span class="font-medium">Assigned:</span>
                          <span class="ml-1">{{ date('M d, Y H:i', strtotime($batch->assigned_at)) }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                          @php
                            $deadline = strtotime($batch->deadline);
                            $now = time();
                            $hoursLeft = ($deadline - $now) / 3600;
                            $isUrgent = $hoursLeft < 24;
                          @endphp
                          <svg class="w-4 h-4 mr-2 {{ $isUrgent ? 'text-red-500' : 'text-yellow-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          <span class="font-medium">Deadline:</span>
                          <span class="ml-1 {{ $isUrgent ? 'text-red-600 font-semibold' : '' }}">
                            {{ date('M d, Y H:i', $deadline) }}
                          </span>
                          @if($isUrgent)
                            <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">URGENT</span>
                          @endif
                        </div>
                      </div>
                    </td>

                    <td class="px-6 py-4">
                      @if($batch->status == 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          Pending
                        </span>
                      @elseif($batch->status == 'in_progress')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                          <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                          </svg>
                          In Progress
                        </span>
                      @elseif($batch->status == 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          Completed
                        </span>
                      @elseif($batch->status == 'overdue')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                          </svg>
                          Overdue
                        </span>
                      @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                          {{ ucfirst($batch->status) }}
                        </span>
                      @endif
                    </td>

                    {{-- <td class="px-6 py-4 text-center">
  <a href="{{ route('reader.assignments.download', $batch->batch_no) }}"
     class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
     download="{{ $batch->batch_no }}.zip">
    Open in RadiAnt
  </a>
</td> --}}


                    <td class="px-6 py-4">
                      <div class="flex justify-center space-x-2">
                        {{-- <a href="{{ route('reader.assignments.download', ['batch_no' => $batch->batch_no]) }}"
                           class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                          </svg>
                          Download
                        </a> --}}

                       <a href="{{ route('reader.assignments.download', ['batch_no' => $batch->batch_no]) }}"
                           class="inline-flex items-center px-3 py-2 border border-indigo-300 text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                          </svg>
                          View
                        </a>

                        @if($batch->status == 'completed')
                          <button class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-50 cursor-not-allowed" disabled>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Done
                          </button>
                        @else
                          <a href="{{ route('reader.assignments.report.create', ['batch_no' => $batch->batch_no]) }}"
                             class="inline-flex items-center px-3 py-2 border border-green-300 text-sm leading-4 font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Report
                          </a>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
