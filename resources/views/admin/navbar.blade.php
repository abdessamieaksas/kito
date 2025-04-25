<header class="bg-white shadow-sm border-b">
  <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo Section -->
      <div class="flex-shrink-0">
        <a href="{{ route('dashboard') }}">
          <img src="/images/logo.png" alt="Logo" class="h-10 w-auto">
        </a>
      </div>

      <!-- Right Section: Authenticated User Dropdown -->
      <div class="flex items-center space-x-4">
        @auth
        <div class="relative">
          <button
            type="button"
            class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none"
            id="userMenuButton"
          >
            <img src="/admin/imgs/avatar.png" alt="User Avatar" class="w-10 h-10 rounded-full border border-gray-300">
            <span class="ml-2 hidden sm:inline">{{ Auth::user()->name }}</span>
            <svg class="ml-1 w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
          </button>

          <!-- Dropdown -->
          <div
            id="userDropdown"
            class="absolute right-0 mt-2 w-60 bg-white rounded-md shadow-lg py-2 z-50 hidden"
          >
            <div class="px-4 py-2 text-sm text-gray-500 border-b">{{ Auth::user()->email }}</div>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              <i class="fa fa-user mr-2"></i> Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fa fa-sign-out mr-2"></i> Log Out
              </button>
            </form>
          </div>
        </div>
        @endauth
      </div>

    </div>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('userMenuButton');
    const dropdown = document.getElementById('userDropdown');

    button.addEventListener('click', function (e) {
      e.stopPropagation();
      dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
      if (!dropdown.contains(e.target) && !button.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  });
</script>
