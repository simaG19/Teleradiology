{{-- resources/views/admin/users/hospitals.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <div class="bg-green-500 p-2 rounded-lg shadow-md">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Hospitals</h1>
          <p class="text-sm text-gray-500">Manage registered hospital accounts and billing</p>
        </div>
      </div>
      <a href="{{ route('admin.users.hospitals.create') }}"
         class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 text-center">
        Add New Hospital
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
        @if($hospitals->isEmpty())
          {{-- Empty State --}}
          <div class="text-center py-16 px-4">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hospital users found</h3>
            <p class="text-gray-500 mb-6">Get started by adding your first hospital account.</p>
            <a href="{{ route('admin.users.hospitals.create') }}"
               class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-200">
              Add New Hospital
            </a>
          </div>
        @else
          {{-- Desktop Table View --}}
          <div class="hidden lg:block overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
              <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Hospital Name
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Email
                  </th>
                  <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($hospitals as $hospital)
                  <tr class="hover:bg-green-50 transition-colors duration-200 animate-fade-in">
                    {{-- Name --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-semibold text-sm">
                          {{ substr($hospital->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $hospital->name }}</span>
                      </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4 text-sm text-gray-700">
                      {{ $hospital->email }}
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-center">
                      <div class="flex gap-2 justify-center flex-wrap">
                        <a href="{{ route('admin.hospitals.edit', $hospital) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Edit
                        </a>
                        <a href="{{ route('admin.hospitals.billing', $hospital) }}"
                           class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-medium text-sm rounded-lg hover:bg-amber-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                          Billing
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Mobile Card View --}}
          <div class="lg:hidden divide-y divide-gray-200">
            @foreach($hospitals as $hospital)
              <div class="p-4 hover:bg-gray-50 transition-colors duration-200 animate-fade-in">
                {{-- Card Header --}}
                <div class="flex items-start justify-between mb-3">
                  <div class="flex items-center gap-3 flex-1">
                    <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-semibold text-base">
                      {{ substr($hospital->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                      <h3 class="text-base font-bold text-gray-900 break-words">{{ $hospital->name }}</h3>
                      <p class="text-xs text-gray-500 mt-1">{{ $hospital->email }}</p>
                    </div>
                  </div>
                </div>

                {{-- Card Actions --}}
                <div class="pt-3 border-t border-gray-200 flex gap-2">
                  <a href="{{ route('admin.hospitals.edit', $hospital) }}"
                     class="flex-1 px-3 py-2 bg-blue-600 text-white font-medium text-center text-sm rounded-lg hover:bg-blue-700 transition-all duration-200 active:scale-95">
                    Edit
                  </a>
                  <a href="{{ route('admin.hospitals.billing', $hospital) }}"
                     class="flex-1 px-3 py-2 bg-amber-600 text-white font-medium text-center text-sm rounded-lg hover:bg-amber-700 transition-all duration-200 active:scale-95">
                    Billing
                  </a>
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
