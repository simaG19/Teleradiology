{{-- resources/views/admin/file_types/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="bg-indigo-500 p-2 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-900">File Types</h1>
            <p class="text-sm text-gray-500">Define your DICOM modality price list</p>
          </div>
        </div>
        <a href="{{ route('admin.file_types.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          + New File Type
        </a>
      </div>
    </div>
  </x-slot>

  <div class="flex h-screen overflow-hidden bg-gray-50">
    @include('admin.sidebar')

    <main class="flex-1 overflow-auto">
      <div class="p-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
          <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
          </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          @if($types->isEmpty())
            <div class="text-center py-16">
              <h3 class="text-lg font-medium text-gray-900 mb-2">No File Types Defined</h3>
              <p class="text-gray-500">Use “New File Type” to add modalities and pricing.</p>
            </div>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anatomy</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price per File</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($types as $type)
                    <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $type->name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $type->anatomy }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ number_format($type->price_per_file, 2) }} birr
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                        <a href="{{ route('admin.file_types.edit', $type) }}"
                           class="inline-flex px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                          Edit
                        </a>
                        <form action="{{ route('admin.file_types.destroy', $type) }}"
                              method="POST" class="inline" onsubmit="return confirm('Delete this file type?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                                  class="inline-flex px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </main>
  </div>
</x-app-layout>
