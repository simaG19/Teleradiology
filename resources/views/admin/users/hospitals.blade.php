<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Hospitals</h2>
  </x-slot>

  <div class="flex">
    {{-- Sidebar --}}
    <div class="w-1/5">
      @include('admin.sidebar')
    </div>

    {{-- Main Content --}}
    <div class="w-4/5 py-8 px-4">
      <div class="flex justify-end mb-4">
        <a href="{{ route('admin.users.hospitals.create') }}"
           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
          Add New
        </a>
      </div>

      <div class="bg-white shadow rounded p-6">
        @if($hospitals->isEmpty())
          <p>No hospital users found.</p>
        @else
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                {{-- <th class="px-6 py-3">Status</th> --}}
                <th class="px-6 py-3">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($hospitals as $hospital)
                <tr>
                  <td class="px-6 py-4">{{ $hospital->name }}</td>
                  <td class="px-6 py-4">{{ $hospital->email }}</td>
                  {{-- <td class="px-6 py-4">
                    @if ($hospital->is_active)
                     <span class="text-red-600 font-semibold">Inactive</span>

                    @else
                      <span class="text-green-600 font-semibold">Active</span>
                    @endif
                  </td> --}}
                  <td class="px-6 py-4 space-x-2 whitespace-nowrap">
                    {{-- <a href="{{ route('admin.hospitals.show', $hospital) }}"
                       class="px-2 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">View</a> --}}

                    <a href="{{ route('admin.hospitals.edit', $hospital) }}"
                       class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>

                    <a href="{{ route('admin.hospitals.billing', $hospital) }}"
                       class="px-2 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">Billing</a>

                    {{-- @if ($hospital->is_active)
                      <form action="{{ route('admin.hospitals.deactivate', $hospital->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                          Deactivate
                        </button>
                      </form>
                    @else
                      <form action="{{ route('admin.hospitals.activate', $hospital->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                          Activate
                        </button>
                      </form>
                    @endif --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
