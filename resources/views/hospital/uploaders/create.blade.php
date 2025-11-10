{{-- resources/views/hospital/uploaders/create.blade.php --}}
<x-ho-lay>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Create New Uploader</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-md mx-auto sm:px-6 lg:px-8">
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

        <form action="{{ route('hospital.uploaders.store') }}" method="POST">
          @csrf

          {{-- Name --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" required
                   value="{{ old('name') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md" />
          </div>

          {{-- Email --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required
                   value="{{ old('email') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md" />
          </div>

          {{-- Password --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" required
                   class="mt-1 block w-full border-gray-300 rounded-md" />
          </div>

          {{-- Confirm Password --}}
          <div class="mb-6">
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 block w-full border-gray-300 rounded-md" />
          </div>

          <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Create Uploader
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<x-ho-lay>
