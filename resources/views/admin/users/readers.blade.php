{{-- resources/views/admin/users/readers.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <div class="bg-purple-500 p-2 rounded-lg shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Readers</h1>
          <p class="text-sm text-gray-500">Manage medical report readers and their assignments</p>
        </div>
      </div>
      <a href="{{ route('admin.users.readers.create') }}"
         class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Reader
      </a>
    </div>
  </x-slot>

  <div class="flex h-full flex-col md:flex-row gap-0 md:gap-6">
    {{-- Sidebar --}}
    <aside class="w-full md:w-64 bg-white border-b md:border-r border-gray-200 hidden md:block rounded-lg shadow-sm">
      @include('admin.sidebar')
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
      <div class="bg-white rounded-lg shadow-lg overflow-hidden animate-fade-in">
        @if($readers->isEmpty())
          {{-- Empty State --}}
          <div class="text-center py-16 px-4">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No readers found</h3>
            <p class="text-gray-500 mb-6">Get started by adding your first medical report reader.</p>
            <a href="{{ route('admin.users.readers.create') }}"
               class="inline-block px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-all duration-200">
              Add New Reader
            </a>
          </div>
        @else
          {{-- Desktop Table View --}}
          <div class="hidden lg:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Assigned Files</th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Reported</th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Unread Assigned</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($readers as $reader)
                  <tr class="hover:bg-purple-50 transition-colors duration-200 animate-fade-in">
                    {{-- ID --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                      #{{ $reader->id }}
                    </td>

                    {{-- Name --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold text-sm">
                          {{ substr($reader->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $reader->name }}</span>
                      </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                      {{ $reader->email }}
                    </td>

                    {{-- Assigned Files --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                        {{ $reader->assigned_count ?? 0 }}
                      </span>
                    </td>

                    {{-- Reported --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">
                        {{ $reader->reported_count ?? 0 }}
                      </span>
                    </td>

                    {{-- Unread & Assigned --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      @if(($reader->unread_count ?? 0) > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-800 font-semibold text-sm animate-pulse">
                          {{ $reader->unread_count }}
                        </span>
                      @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-semibold text-sm">
                          {{ $reader->unread_count ?? 0 }}
                        </span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Mobile Card View --}}
          <div class="lg:hidden divide-y divide-gray-200">
            @foreach($readers as $reader)
              <div class="p-4 hover:bg-purple-50 transition-colors duration-200 animate-fade-in">
                {{-- Card Header --}}
                <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-200">
                  <div class="flex items-center gap-3 flex-1">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold text-base">
                      {{ substr($reader->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                      <h3 class="text-base font-bold text-gray-900 break-words">{{ $reader->name }}</h3>
                      <p class="text-xs text-gray-500 mt-1">ID #{{ $reader->id }}</p>
                    </div>
                  </div>
                </div>

                {{-- Card Content --}}
                <div class="space-y-3 mb-4">
                  <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Email</p>
                    <p class="text-sm text-gray-700 break-all">{{ $reader->email }}</p>
                  </div>

                  <div class="grid grid-cols-3 gap-3 pt-3 border-t border-gray-200">
                    <div class="text-center">
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Assigned</p>
                      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-bold text-sm">
                        {{ $reader->assigned_count ?? 0 }}
                      </span>
                    </div>

                    <div class="text-center">
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Reported</p>
                      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-800 font-bold text-sm">
                        {{ $reader->reported_count ?? 0 }}
                      </span>
                    </div>

                    <div class="text-center">
                      <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Unread</p>
                      @if(($reader->unread_count ?? 0) > 0)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold text-sm animate-pulse">
                          {{ $reader->unread_count }}
                        </span>
                      @else
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-800 font-bold text-sm">
                          {{ $reader->unread_count ?? 0 }}
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </main>
  </div>

  {{-- Animations --}}
  <style>
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.5s ease-out forwards;
    }
  </style>
</x-admin-lay>
