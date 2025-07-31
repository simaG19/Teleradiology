{{-- resources/views/hospital/uploaders/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">Edit Uploader: {{ $uploader->name }}</h2>
      <a href="{{ route('hospital.uploaders.index') }}"
         class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
        ← Back
      </a>
    </div>
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

      <form action="{{ route('hospital.uploaders.update', $uploader) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Name</label>
          <input type="text" name="name" required
                 class="mt-1 block w-full border-gray-300 rounded-md"
                 value="{{ old('name', $uploader->name) }}">
        </div>

        {{-- Email --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">Email</label>
          <input type="email" name="email" required
                 class="mt-1 block w-full border-gray-300 rounded-md"
                 value="{{ old('email', $uploader->email) }}">
        </div>

        {{-- Password (optional) --}}
        <div class="mb-4">
          <label class="block text-sm font-medium">New Password <span class="text-xs text-gray-500">(leave blank to keep current)</span></label>
          <input type="password" name="password"
                 class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        {{-- Confirm Password --}}
        <div class="mb-6">
          <label class="block text-sm font-medium">Confirm Password</label>
          <input type="password" name="password_confirmation"
                 class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="flex justify-end space-x-2">
          <a href="{{ route('hospital.uploaders.index') }}"
             class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
            Cancel
          </a>
          <button type="submit"
                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
