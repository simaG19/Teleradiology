{{-- resources/views/admin/sidebar.blade.php --}}
<nav class="h-full bg-gray-800 text-gray-100 w-64 flex-shrink-0">
    <div class="px-6 py-4 text-2xl font-semibold border-b border-gray-700">
        Admin Panel
    </div>
    <ul class="mt-6">
        <li class="px-6 py-2 hover:bg-gray-700">
            <a href="{{ route('admin.images.index') }}" class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <span>All Records</span>
            </a>
        </li>

        {{-- <li class="px-6 py-2 hover:bg-gray-700">
            <a href="{{ route('admin.images.assign', ['batch_no' => '']) }}" class="flex items-center space-x-3"
               onclick="event.preventDefault(); alert('First select a batch from All Uploads');">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 11V5a1 1 0 112 0v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H5a1 1 0 110-2h6z" />
                </svg>
                <span>Users List</span>
            </a>
        </li> --}}
       <!-- Assigned List -->
<li class="px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.assignments.index') ? 'bg-gray-800 text-white' : '' }}">
    <a href="{{ route('admin.assignments.index') }}" class="flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7" />
        </svg>
        <span>Assigned List</span>
    </a>
</li>

<!-- Clients -->
<li class="px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.clients') ? 'bg-gray-800 text-white' : '' }}">
    <a href="{{ route('admin.users.clients') }}" class="flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 12h14M5 12l5-5m-5 5l5 5" />
        </svg>
        <span>Clients</span>
    </a>
</li>

<!-- Hospitals -->
<li class="px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.hospitals') ? 'bg-gray-800 text-white' : '' }}">
    <a href="{{ route('admin.users.hospitals') }}" class="flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M9 21V3m6 18V3" />
        </svg>
        <span>Hospitals</span>
    </a>
</li>

<!-- Readers -->
<li class="px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.readers') ? 'bg-gray-800 text-white' : '' }}">
    <a href="{{ route('admin.users.readers') }}" class="flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Readers</span>
    </a>
</li>

        <li class="px-6 py-2 hover:bg-gray-700">
            <a href="{{ route('admin.images.index') }}" class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>
