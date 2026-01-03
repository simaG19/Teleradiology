{{-- resources/views/admin/file_types/create.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">New File Type</h2>
  </x-slot>

  <div class="py-8 max-w-md mx-auto sm:px-6 lg:px-8">
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

 <form action="{{ route('admin.file_types.store') }}" method="POST">
  @csrf

  <div class="mb-4">
    <label class="block text-sm font-medium">Name</label>
    <input type="text" name="name" required value="{{ old('name') }}"
           class="mt-1 block w-full border-gray-300 rounded-md" />
  </div>

  <div class="mb-4">
    <label class="block text-sm font-medium">Anatomy</label>
    <select name="anatomy" class="mt-1 block w-full border-gray-300 rounded-md">
      <option value="">— Select anatomy —</option>
      @php
        $anatomies = ['Chest','Head','Abdomen','Pelvis','Spine','Extremity','Cardiac','Vascular','Other'];
      @endphp
      @foreach($anatomies as $a)
        <option value="{{ $a }}" {{ old('anatomy') === $a ? 'selected' : '' }}>{{ $a }}</option>
      @endforeach
    </select>
    @error('anatomy') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="mb-6">
    <label class="block text-sm font-medium">Price per File (birr)</label>
    <input type="number" name="price_per_file" required step="0.01"
           value="{{ old('price_per_file') }}"
           class="mt-1 block w-full border-gray-300 rounded-md" />
  </div>

  <div class="flex justify-end">
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      Create
    </button>
  </div>
</form>

    </div>
  </div>
</x-admin-lay>
