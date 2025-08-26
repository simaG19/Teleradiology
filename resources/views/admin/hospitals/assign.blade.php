{{-- resources/views/admin/hospitals/assign.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Assign Hospital Batch: {{ $upload->id }}</h2>
  </x-slot>

  <div class="py-8 max-w-lg mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      {{-- Show some details about this batch --}}
      <div class="mb-6">
        <p><strong>Uploader:</strong> {{ $upload->uploader->name }} ({{ $upload->uploader->email }})</p>
        <p><strong>Uploaded At:</strong> {{ $upload->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Urgency:</strong>
          @if($upload->urgency === 'urgent')
            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
          @else
            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Normal</span>
          @endif
        </p>
        <p><strong>Clinical History:</strong> {{ $upload->clinical_history ?: '—' }}</p>
      </div>

      <form action="{{ route('admin.images.assign.store', ['batch_no' => $upload->id]) }}"
            method="POST">
        @csrf

        {{-- Reader dropdown --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Assign to Reader</label>
          <select name="reader_id" required
                  class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">— select reader —</option>
            @foreach($readers as $reader)
              <option value="{{ $reader->id }}">
                {{ $reader->name }} ({{ $reader->email }})
              </option>
            @endforeach
          </select>
        </div>

        {{-- Deadline --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Deadline</label>
          <input type="datetime-local" name="deadline" required
                 class="mt-1 block w-full border-gray-300 rounded-md" />
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Assign
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
