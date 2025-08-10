<nav class="h-full bg-gradient-to-b from-slate-900 to-slate-800 text-white w-72 flex-shrink-0 shadow-2xl">
    <!-- Header -->
    <div class="px-6 py-6 border-b border-slate-700">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Admin Panel</h2>
                <p class="text-slate-300 text-sm">Teleradiology System</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="px-4 py-6">
        <ul class="space-y-2">

             <li>
                <a href="{{ route('admin.batches.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.batches.index') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">New Records</span>
                        <p class="text-slate-300 text-xs">DICOM Batches</p>
                    </div>
                </a>
            </li>

            <!-- All Records -->
            <li>
                <a href="{{ route('admin.images.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.images.index') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">All Records</span>
                        <p class="text-slate-300 text-xs">DICOM Batches</p>
                    </div>
                </a>
            </li>
<li class="px-6 py-2 hover:bg-gray-700">
  <a href="{{ route('admin.hospitals.uploads.all') }}" class="flex items-center space-x-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" /* …icon… */>
      <!-- icon path here -->
    </svg>
    <span>Hospital Uploads</span>
  </a>
</li>

            <!-- Assigned List -->
            <li>
                <a href="{{ route('admin.assignments.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.assignments.index') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Assigned List</span>
                        <p class="text-slate-300 text-xs">Active Assignments</p>
                    </div>
                </a>
            </li>




            <!-- Divider -->
            <li class="py-2">
                <div class="border-t border-slate-700"></div>
                <p class="text-slate-400 text-xs font-medium mt-3 mb-2 px-4">USER MANAGEMENT</p>
            </li>

            <!-- Clients -->
            <li>
                <a href="{{ route('admin.users.clients') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.clients') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Clients</span>
                        <p class="text-slate-300 text-xs">Client Management</p>
                    </div>
                </a>
            </li>

            <!-- Hospitals -->
            <li>
                <a href="{{ route('admin.users.hospitals') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.hospitals') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Hospitals</span>
                        <p class="text-slate-300 text-xs">Hospital Network</p>
                    </div>
                </a>
            </li>



            <!-- Readers -->
            <li>
                <a href="{{ route('admin.users.readers') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.readers') ? 'bg-blue-600 shadow-lg' : '' }}">
                    <div class="bg-slate-700 p-2 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Readers</span>
                        <p class="text-slate-300 text-xs">Radiologists</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <!-- Bottom Section -->
   <div class="p-4 border-t">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-red-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Logout</span>
        </button>
    </form>
</div>
</nav>
