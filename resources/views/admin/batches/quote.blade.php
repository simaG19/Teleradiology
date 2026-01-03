{{-- resources/views/admin/batches/quote.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Set Price for Batch {{ $batch->id }}</h2>
  </x-slot>

  <div class="py-8 max-w-md mx-auto">
    <div class="bg-white shadow rounded p-6">
      <form
        action="{{ route('admin.batches.quote.update', $batch) }}"
        method="POST"
      >
        @csrf

        {{-- If your update route expects PUT, uncomment this --}}
        {{-- @method('PUT') --}}

        <div class="mb-4">
          <label class="block text-sm font-medium">File Type</label>
         <select
  name="file_type_id"
  required
  class="mt-1 block w-full border-gray-300 rounded-md"
>
  <option value="">— select —</option>
  @foreach(\App\Models\FileType::orderBy('name')->get() as $type)
    <option
      value="{{ $type->id }}"
      {{ old('file_type_id', $batch->file_type_id) == $type->id ? 'selected' : '' }}
    >
      {{ $type->name }}{{ $type->anatomy ? ' (' . $type->anatomy . ')' : '' }}
      &nbsp;&mdash;&nbsp;{{ number_format($type->price_per_file, 2) }} birr/file
    </option>
  @endforeach
</select>

@error('file_type_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
            Set Price
          </button>
        </div>
      </form>
    </div>
  </div>
</x-admin-lay>
