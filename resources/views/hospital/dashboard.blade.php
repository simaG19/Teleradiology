<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">Hospital Dashboard</h2>
      {{-- +Add Uploader button logic --}}
      @php
        $limit = $profile->uploader_account_limit;
        $count = $uploaderCount;
      @endphp
      @if($limit === 0 || $count < $limit)
        <a href="{{ route('hospital.uploaders.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          + Add Uploader
        </a>
      @else
        <button disabled
                title="Limit reached ({{ $count }}/{{ $limit }})"
                class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
          + Add Uploader
        </button>
      @endif
    </div>
  </x-slot>

  <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    {{-- Existing usage/billing cards… --}}

    {{-- 3) New Uploads Table --}}
    <div class="bg-white shadow rounded p-6">
      <h3 class="text-lg font-medium mb-4">All Uploads</h3>

      @if($uploads->isEmpty())
        <p class="text-gray-600">No uploads found.</p>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uploader</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Batch ID</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
              <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Report</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($uploads as $u)
              <tr>
               <td class="px-4 py-2 text-sm text-gray-700">
  {{ $u->uploader->name }}
</td>

                <td class="px-4 py-2 text-sm text-gray-700">{{ $u->id }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  {{ $u->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  {{ optional($u->fileType)->name ?? '—' }}
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">
                  @if(is_null($u->quoted_price))
                    <span class="text-gray-500">TBD</span>
                  @else
                    {{ number_format($u->quoted_price,2) }} birr
                  @endif
                </td>
                <td class="px-4 py-2 text-sm">
                  @php
                    $report = $u->assignments->first()?->report;
                  @endphp

                  @if($report)
                    <a href="{{ Storage::url($report->pdf_path) }}"
                       target="_blank"
                       class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                      View
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
