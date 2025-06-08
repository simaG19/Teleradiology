<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Add New Reader</h2>
  </x-slot>

  <div class="flex h-screen overflow-hidden">
    @include('admin.sidebar')

    <main class="flex-1 bg-gray-100 p-6 overflow-auto">
      <div class="max-w-md mx-auto bg-white p-6 shadow rounded">
        @if($errors->any())
          <div class="mb-4 text-red-600">
            <ul class="list-disc list-inside">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.users.readers.store') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" required
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('name') }}">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('email') }}">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" required
                   class="mt-1 block w-full border-gray-300 rounded-md">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 block w-full border-gray-300 rounded-md">
          </div>

          <div class="text-right">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Create Reader
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</x-app-layout>
