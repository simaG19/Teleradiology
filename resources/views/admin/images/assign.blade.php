{{-- resources/views/admin/images/assign.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Assign Reader</h2>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto">
    <div class="bg-white shadow rounded p-6">
      @php
        // determine presented batch id for form route
        if (isset($type) && $type === 'hospital') {
            $form_batch = $upload->id;
            $displayLabel = "Hospital upload: {$upload->id}";
        } elseif (isset($type) && $type === 'batch') {
            $form_batch = $batchModel->id;
            $displayLabel = "Batch: {$batchModel->id}";
        } else {
            $form_batch = $batch_no ?? null;
            $displayLabel = "Batch: {$batch_no}";
        }
      @endphp

      <div class="mb-4">
        <div class="text-sm text-gray-600">Assigning: <span class="font-medium">{{ $displayLabel }}</span></div>
      </div>

      @if (! $form_batch)
        <div class="text-red-600">Invalid batch. Cannot show assign form.</div>
      @else
<form action="{{ route('admin.images.assign.store', ['batch_no' => $form_batch]) }}" method="POST">
        @csrf

        <div class="mb-4">
          <label class="block text-sm font-medium">Assign To (Reader)</label>
          <select name="reader_id" required class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">— select reader —</option>
            @foreach($readers as $r)
              <option value="{{ $r->id }}">{{ $r->name }} — {{ $r->email }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium">Deadline</label>
          <input type="datetime-local" name="deadline" required class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="flex justify-end">
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Assign</button>
        </div>
      </form>
      @endif
    </div>
  </div>
</x-app-layout>
