<div id="sidebar-container" class="flex h-screen">
  <!-- Sidebar Toggle Button (Mobile) -->
  <button
    id="sidebar-toggle"
    class="fixed top-4 left-4 z-50 lg:hidden p-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800 transition-all duration-200"
    aria-label="Toggle sidebar">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Mobile Overlay (Hidden by default) -->
  <div
    id="sidebar-overlay"
    class="hidden lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30 transition-opacity duration-300"
  ></div>

  <!-- Sidebar Navigation -->
  <nav
    id="sidebar"
    class="h-full bg-gradient-to-b from-slate-900 to-slate-800 text-white w-72 flex-shrink-0 shadow-2xl transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 fixed lg:relative z-40 overflow-y-auto"
  >
    <!-- Header -->
    <div class="px-6 py-6 border-b border-slate-700 sticky top-0 bg-gradient-to-b from-slate-900 to-slate-800">
      <div class="flex items-center space-x-3">
        <div class="bg-blue-500 p-2 rounded-lg transform transition-transform duration-300 hover:scale-110">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <div class="flex-1 min-w-0">
          <h2 class="text-xl font-bold truncate">Admin Panel</h2>
          <p class="text-slate-300 text-sm truncate">Teleradiology System</p>
        </div>
        <!-- Minimize Button (Desktop only) -->
        <button
          id="sidebar-minimize"
          class="hidden lg:flex p-2 rounded-lg hover:bg-slate-700 transition-all duration-200 transform hover:scale-110"
          aria-label="Minimize sidebar"
          title="Minimize sidebar">
          <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Navigation Menu -->
    <div class="px-4 py-6 space-y-4">
      <ul class="space-y-2">
        <!-- New Records -->
        <li class="nav-item group">
          <a href="{{ route('admin.batches.index') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.batches.index') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">New Records</span>
              <p class="text-slate-300 text-xs truncate">DICOM Batches</p>
            </div>
          </a>
        </li>

        <!-- All Records -->
        <li class="nav-item group">
          <a href="{{ route('admin.images.index') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.images.index') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">All Records</span>
              <p class="text-slate-300 text-xs truncate">DICOM Batches</p>
            </div>
          </a>
        </li>

        <!-- Hospital Uploads -->
        <li class="nav-item group">
          <a href="{{ route('admin.hospitals.uploads.all') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.hospitals.uploads.all') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Hospital Uploads</span>
              <p class="text-slate-300 text-xs truncate">Upload Management</p>
            </div>
          </a>
        </li>

        <!-- Assigned List -->
        <li class="nav-item group">
          <a href="{{ route('admin.assignments.index') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.assignments.index') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Assigned List</span>
              <p class="text-slate-300 text-xs truncate">Active Assignments</p>
            </div>
          </a>
        </li>

        <!-- Divider -->
        <li class="py-4">
          <div class="border-t border-slate-700"></div>
          <p class="text-slate-400 text-xs font-medium mt-4 px-4 uppercase tracking-wide">User Management</p>
        </li>

        <!-- Clients -->
        <li class="nav-item group">
          <a href="{{ route('admin.users.clients') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.clients') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Clients</span>
              <p class="text-slate-300 text-xs truncate">Client Management</p>
            </div>
          </a>
        </li>

        <!-- Hospitals -->
        <li class="nav-item group">
          <a href="{{ route('admin.users.hospitals') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.hospitals') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Hospitals</span>
              <p class="text-slate-300 text-xs truncate">Hospital Network</p>
            </div>
          </a>
        </li>

        <!-- Readers -->
        <li class="nav-item group">
          <a href="{{ route('admin.users.readers') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.readers') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Readers</span>
              <p class="text-slate-300 text-xs truncate">Radiologists</p>
            </div>
          </a>
        </li>


        <li class="nav-item group">
          <a href="{{ route('admin.users.readers') }}"
             class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-slate-700 hover:translate-x-1 {{ request()->routeIs('admin.users.readers') ? 'bg-blue-600 shadow-lg' : '' }}">
            <div class="bg-slate-700 p-2 rounded-md transform transition-transform duration-200 group-hover:scale-110">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <span class="font-medium block truncate">Readers</span>
              <p class="text-slate-300 text-xs truncate">Radiologists</p>
            </div>
          </a>
        </li>
      </ul>
    </div>

    <!-- Bottom Section - Logout -->
    <div class="p-4 border-t border-slate-700 absolute bottom-0 w-full bg-gradient-to-t from-slate-800 to-transparent">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button
          type="submit"
          class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-slate-300 hover:text-red-400 hover:bg-slate-700 rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
          <span class="font-medium">Logout</span>
        </button>
      </form>
    </div>
  </nav>
</div>

<style>
  /* Smooth transitions */
  #sidebar {
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 116, 139, 0.5) transparent;
  }

  #sidebar::-webkit-scrollbar {
    width: 6px;
  }

  #sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  #sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(100, 116, 139, 0.5);
    border-radius: 3px;
  }

  #sidebar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(100, 116, 139, 0.7);
  }

  /* Navigation items animation */
  .nav-item a {
    position: relative;
  }

  .nav-item a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #3b82f6, #60a5fa);
    border-radius: 0 2px 2px 0;
    opacity: 0;
    transform: scaleY(0);
    transform-origin: top;
    transition: all 0.3s ease;
  }

  .nav-item a:hover::before {
    opacity: 1;
    transform: scaleY(1);
  }

  /* Minimize animation */
  @keyframes slideOut {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(-100%);
      opacity: 0;
    }
  }

  @keyframes slideIn {
    from {
      transform: translateX(-100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
</style>

<script>
  // <CHANGE> Inline JavaScript for sidebar toggle and minimize functionality
  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    const minimizeBtn = document.getElementById('sidebar-minimize');
    const sidebarContainer = document.getElementById('sidebar-container');
    let isMinimized = localStorage.getItem('sidebarMinimized') === 'true';

    // Mobile toggle
    toggle.addEventListener('click', function() {
      const isOpen = sidebar.classList.contains('-translate-x-full');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });

    // Overlay click to close
    overlay.addEventListener('click', function() {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    });

    // Desktop minimize/expand
    minimizeBtn.addEventListener('click', function() {
      isMinimized = !isMinimized;
      localStorage.setItem('sidebarMinimized', isMinimized);

      if (isMinimized) {
        // Minimize
        sidebar.classList.add('w-20');
        sidebar.classList.remove('w-72');

        // Hide text content
        document.querySelectorAll('.nav-item a > div:last-child').forEach(el => {
          el.classList.add('hidden');
        });

        // Hide header description
        document.querySelector('.px-6.py-6 > div > div:last-child > p').classList.add('hidden');

        // Adjust icon spacing
        document.querySelectorAll('.flex.items-center.space-x-3').forEach(el => {
          el.classList.remove('space-x-3');
          el.classList.add('space-x-0');
          el.classList.add('justify-center');
        });

        // Rotate minimize button
        minimizeBtn.querySelector('svg').classList.add('rotate-180');
      } else {
        // Expand
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-72');

        // Show text content
        document.querySelectorAll('.nav-item a > div:last-child').forEach(el => {
          el.classList.remove('hidden');
        });

        // Show header description
        document.querySelector('.px-6.py-6 > div > div:last-child > p').classList.remove('hidden');

        // Restore icon spacing
        document.querySelectorAll('.flex.items-center.space-x-3').forEach(el => {
          el.classList.add('space-x-3');
          el.classList.remove('space-x-0');
          el.classList.remove('justify-center');
        });

        // Rotate minimize button back
        minimizeBtn.querySelector('svg').classList.remove('rotate-180');
      }
    });

    // Initialize minimized state on load
    if (isMinimized) {
      minimizeBtn.click();
    }

    // Close mobile sidebar when clicking a link
    document.querySelectorAll('.nav-item a').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth < 1024) {
          sidebar.classList.add('-translate-x-full');
          overlay.classList.add('hidden');
        }
      });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth >= 1024) {
        overlay.classList.add('hidden');
        if (!isMinimized) {
          sidebar.classList.remove('-translate-x-full');
        }
      }
    });
  });
</script>
