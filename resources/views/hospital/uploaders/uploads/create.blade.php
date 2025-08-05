{{-- resources/views/hospital/uploaders/uploads/create.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Send New DICOM Zip</h2>
  </x-slot>

  <div class="py-8 max-w-lg mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      @if($errors->any())
        <div class="mb-4 text-red-600">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('uploader.uploads.store') }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf

        {{-- ZIP Upload --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">ZIP of DICOM Files</label>
          <input type="file"
                 name="archive"
                 accept=".zip"
                 required
                 class="mt-1 block w-full border-gray-300 rounded-md" />
          @error('archive')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Urgency --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Urgency</label>
          <select name="urgency"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="normal" {{ old('urgency')=='normal' ? 'selected':'' }}>Normal (24 hrs)</option>
            <option value="urgent" {{ old('urgency')=='urgent' ? 'selected':'' }}>Urgent (4 hrs)</option>
          </select>
          @error('urgency')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Clinical History --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Clinical History (optional)</label>
          <textarea name="clinical_history"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    placeholder="Any relevant patient history…">{{ old('clinical_history') }}</textarea>
          @error('clinical_history')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- File Type --}}
        <div class="mb-6">
          <label class="block text-sm font-medium">Study Type</label>
          <select name="file_type_id"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">— Select type —</option>
            @foreach(\App\Models\FileType::orderBy('name')->get() as $type)
              <option value="{{ $type->id }}"
                {{ old('file_type_id') == $type->id ? 'selected':'' }}>
                {{ $type->name }} &mdash; {{ number_format($type->price_per_file,2) }} birr/file
              </option>
            @endforeach
          </select>
          @error('file_type_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Upload
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
