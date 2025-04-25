<div class="sidebar w-64 min-h-screen bg-white shadow-md relative">
  <h1 class="text-center text-2xl font-bold p-5">Keto</h1>
  <ul class="space-y-2 px-5">
    @auth
    @if (Auth::user()->role==='admin')
    <li>
      <a href="{{ route('dashboard') }}" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="fa-regular fa-chart-bar w-6 mr-3"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('rooms.index') }}" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-hotel w-6 mr-3"></i>
        <span>Rooms</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="far fa-user w-6 mr-3"></i>
        <span>Profile</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-diagram-project w-6 mr-3"></i>
        <span>Projects</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-graduation-cap w-6 mr-3"></i>
        <span>Courses</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="far fa-user-circle w-6 mr-3"></i>
        <span>Freinds</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="far fa-file w-6 mr-3"></i>
        <span>Files</span>
      </a>
    </li>
    <li>
      <a href="#" class="flex items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="fas fa-cog w-6 mr-3"></i>
        <span>Setting</span>
      </a>
    </li>
    @else
    <li>
      <a href="#" class="flex bg-gray-100 items-center rounded-md p-3 text-gray-700 hover:bg-gray-100">
        <i class="far fa-user w-6 mr-3"></i>
        <span>Profile</span>
      </a>
    </li>
    @endif

  </ul>
  @endauth
</div>