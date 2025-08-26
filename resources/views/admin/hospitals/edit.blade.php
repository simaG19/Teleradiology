{{-- resources/views/admin/hospitals/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Edit Hospital: {{ $user->name }}</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
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








        {{-- Notice we pass ['hospital' => $user->id] --}}
        <form action="{{ url('admin/hospitals/'.$user->id) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Contact Person / User Name --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Contact Person</label>
            <input type="text" name="name" required
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('name', $user->name) }}">
          </div>

          {{-- Email --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('email', $user->email) }}">
          </div>

          <div class="mb-4">
  <label class="block text-sm font-medium">Hospital Status</label>
  <select name="is_active" class="mt-1 block w-full border-gray-300 rounded-md">
    <option value="1" {{ $profile->is_active ? 'selected' : '' }}>Active</option>
    <option value="0" {{ !$profile->is_active ? 'selected' : '' }}>Inactive</option>
  </select>
</div>

          {{-- Monthly File Upload Limit --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Monthly File Upload Limit</label>
            <input type="number" name="monthly_file_limit" min="0"
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('monthly_file_limit', $profile->monthly_file_limit) }}">
            <p class="text-xs text-gray-500">0 = unlimited</p>
          </div>

          {{-- Uploader Accounts Limit --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Uploader Accounts Limit</label>
            <input type="number" name="uploader_account_limit" min="0"
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('uploader_account_limit', $profile->uploader_account_limit) }}">
            <p class="text-xs text-gray-500">0 = unlimited</p>
          </div>

          {{-- Billing Rate --}}
          <div class="mb-4">
            <label class="block text-sm font-medium">Billing Rate (per file)</label>
            <input type="number" name="billing_rate" step="0.01" min="0"
                   class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('billing_rate', $profile->billing_rate) }}">
            <p class="text-xs text-gray-500">Set to 0 for no per-file billing</p>
          </div>

          <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Update Hospital
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
