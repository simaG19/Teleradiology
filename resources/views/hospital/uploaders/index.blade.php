{{-- resources/views/hospital/uploaders/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">My Uploaders</h2>
     @php
  $limit = Auth::user()->hospitalProfile->uploader_account_limit;
  $count = $uploaders->count();
@endphp
<h2><a href="/hospital/dashboard">Dashboard</a></h2>
<div class="flex justify-between items-center mb-4">


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

    </div>
  </x-slot>

  <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      @if($uploaders->isEmpty())
        <p>No uploader accounts have been created yet.</p>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created At
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($uploaders as $uploader)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ $uploader->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ $uploader->email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ $uploader->created_at->format('Y-m-d') }}
                </td>
                <td class="space-x-2">
          {{-- View --}}
          <a href="{{ route('hospital.uploaders.show', $uploader) }}"
             class="px-2 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
            View
          </a>

          {{-- Edit --}}
          <a href="{{ route('hospital.uploaders.edit', $uploader) }}"
             class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
            Edit
          </a>

          {{-- Delete --}}
          <form action="{{ route('hospital.uploaders.destroy', $uploader) }}"
      method="POST" class="inline-block"
      onsubmit="return confirm('Delete this uploader?');">
  @csrf
  @method('DELETE')
  <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
    Delete
  </button>
</form>

        </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</x-app-layout>
