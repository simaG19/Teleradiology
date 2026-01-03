<x-ho-lay>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Hospital Dashboard</h2>
        <p class="text-sm text-gray-600 mt-1">Manage and track all uploads</p>
      </div>
      {{-- +Add Uploader button logic --}}
      @php
        $limit = $profile->uploader_account_limit;
        $count = $uploaderCount;
      @endphp
      @if($limit === 0 || $count < $limit)
        <a href="{{ route('hospital.uploaders.create') }}"
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add Uploader
        </a>
      @else
        <button disabled
                title="Limit reached ({{ $count }}/{{ $limit }})"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-200 text-gray-500 font-medium rounded-lg cursor-not-allowed opacity-60">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add Uploader
        </button>
      @endif
    </div>
  </x-slot>

  <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Section Title --}}
    <div class="mb-8">
      <h3 class="text-xl font-semibold text-gray-900">All Uploads</h3>
      <p class="text-sm text-gray-600 mt-1">{{ $uploads->count() }} total {{ Str::plural('upload', $uploads->count()) }}</p>
    </div>

    {{-- Add Statistics Boxes Section --}}
    @php
      $totalUploads = $uploads->count();
      $thisMonthUploads = $uploads->filter(function($u) {
        return $u->created_at->month == now()->month && $u->created_at->year == now()->year;
      })->count();
      $totalPrice = $uploads->sum('quoted_price') ?? 0;
      $thisMonthPrice = $uploads->filter(function($u) {
        return $u->created_at->month == now()->month && $u->created_at->year == now()->year;
      })->sum('quoted_price') ?? 0;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      {{-- Total Uploads Card --}}
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-600 hover:shadow-lg transition-shadow duration-300 animate-fade-in" style="animation-delay: 0s;">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-medium">Total Uploads</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUploads }}</p>
          </div>
          <div class="bg-blue-100 rounded-full p-3">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
          </div>
        </div>
      </div>

      {{-- This Month Uploads Card --}}
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-medium">This Month</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $thisMonthUploads }}</p>
          </div>
          <div class="bg-blue-100 rounded-full p-3">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
      </div>

      {{-- Total Revenue Card --}}
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600 hover:shadow-lg transition-shadow duration-300 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($totalPrice, 2) }} <span class="text-sm font-normal">birr</span></p>
          </div>
          <div class="bg-green-100 rounded-full p-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      {{-- This Month Revenue Card --}}
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300 animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm font-medium">This Month Revenue</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($thisMonthPrice, 2) }} <span class="text-sm font-normal">birr</span></p>
          </div>
          <div class="bg-green-100 rounded-full p-3">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    {{-- Empty State --}}
    @if($uploads->isEmpty())
      <div class="flex flex-col items-center justify-center py-16 px-4">
        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-9"></path>
        </svg>
        <p class="text-gray-600 font-medium">No uploads found</p>
        <p class="text-gray-500 text-sm mt-1">Start by adding your first upload</p>
      </div>
    @else
      {{-- Converted table to responsive card grid layout --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($uploads as $index => $u)
          <div class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all duration-300 overflow-hidden animate-fade-in"
               style="animation-delay: {{ $index * 50 }}ms">
            
            {{-- Card Header with Uploader Info --}}
            <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 px-6 py-4 border-b border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Uploader</p>
                  <p class="text-lg font-bold text-gray-900 mt-0.5">{{ $u->uploader->name }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-9"></path>
                  </svg>
                </div>
              </div>
            </div>

            {{-- Card Content --}}
            <div class="px-6 py-5 space-y-4">
              {{-- Batch ID --}}
              <div class="flex items-start justify-between gap-3">
                <div>
                  <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Batch ID</p>
                  <p class="font-mono text-sm font-medium text-gray-900">{{ $u->id }}</p>
                </div>
              </div>

              {{-- Divider --}}
              <div class="w-full h-px bg-gray-100"></div>

              {{-- Uploaded At --}}
              <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Uploaded</p>
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-sm text-gray-700">{{ $u->created_at->format('M d, Y • H:i') }}</p>
                </div>
              </div>

              {{-- File Type --}}
              <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">File Type</p>
                <div class="inline-block">
                  @if($u->fileType)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                      {{ $u->fileType->name }}
                    </span>
                  @else
                    <span class="text-sm text-gray-500 italic">Not specified</span>
                  @endif
                </div>
              </div>

              {{-- Price --}}
              <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Price</p>
                @if(is_null($u->quoted_price))
                  <p class="text-sm font-semibold text-gray-400">TBD</p>
                @else
                  <p class="text-lg font-bold text-gray-900">{{ number_format($u->quoted_price, 2) }} <span class="text-sm text-gray-600 font-normal">birr</span></p>
                @endif
              </div>
            </div>

            {{-- Card Footer with Report Button --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3">
              @php
                $report = $u->assignments->first()?->report;
              @endphp

              @if($report)
                <a href="{{ Storage::url($report->pdf_path) }}"
                   target="_blank"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md group/btn">
                  <svg class="w-4 h-4 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                  View Report
                </a>
              @else
                <div class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-200 text-gray-500 font-medium rounded-lg cursor-not-allowed opacity-50">
                  <span>No Report</span>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- Added animations and styles in script tag --}}
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
      animation: fadeIn 0.6s ease-out forwards;
      opacity: 0;
    }

    /* Smooth transitions */
    * {
      @apply transition-colors duration-200;
    }

    /* Focus states for accessibility */
    button:focus-visible,
    a:focus-visible {
      @apply outline-none ring-2 ring-offset-2 ring-blue-500;
    }
  </style>

</x-ho-lay>
