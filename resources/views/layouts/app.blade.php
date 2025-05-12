<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hotel Management') }}</title>

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-gray-50 min-h-screen">
        <!-- Sticky Navbar -->
        <header class="sticky top-0 z-30 bg-white shadow-md">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="/images/logo.png" alt="Logo" class="h-10 w-auto">
                    </a>
                </div>
                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-black hover:text-red-600 font-medium transition">Home</a>
                    <a href="#about" class="text-black hover:text-red-600 font-medium transition">About</a>
                    <a href="#room" class="text-black hover:text-red-600 font-medium transition">Our Room</a>
                    <a href="#gallery" class="text-black hover:text-red-600 font-medium transition">Gallery</a>
                    <a href="#blog" class="text-black hover:text-red-600 font-medium transition">Blog</a>
                    <a href="#contact" class="text-black hover:text-red-600 font-medium transition">Contact Us</a>
                    <a href="{{ route('bookings.index') }}" class="text-black hover:text-red-600 font-medium transition">My Bookings</a>
                </div>
                <!-- User/Guest Actions -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-black hover:text-red-600 font-medium focus:outline-none">
                                <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 1114 0H3z" /></svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-20 hidden group-hover:block">
                                <div class="px-4 py-2 text-xs text-gray-500 border-b">{{ Auth::user()->email }}</div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-black hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-black hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-black hover:bg-red-700 text-white rounded-lg font-semibold transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">Register</a>
                        @endif
                    @endauth
                </div>
                <!-- Mobile Hamburger -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-black hover:text-red-600 focus:outline-none">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </nav>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
                <div class="px-4 py-4 flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="text-black hover:text-red-600 font-medium transition">Home</a>
                    <a href="#about" class="text-black hover:text-red-600 font-medium transition">About</a>
                    <a href="#room" class="text-black hover:text-red-600 font-medium transition">Our Room</a>
                    <a href="#gallery" class="text-black hover:text-red-600 font-medium transition">Gallery</a>
                    <a href="#blog" class="text-black hover:text-red-600 font-medium transition">Blog</a>
                    <a href="#contact" class="text-black hover:text-red-600 font-medium transition">Contact Us</a>
                    <a href="{{ route('bookings.index') }}" class="text-black hover:text-red-600 font-medium transition">My Bookings</a>
                    <a href="{{ route('rooms.available') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow font-semibold transition">Reserve Now</a>
                    @auth
                        <div class="border-t pt-2 mt-2">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 1114 0H3z" /></svg>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-black hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-black hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-black hover:bg-red-700 text-white rounded-lg font-semibold transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
            <script>
                // Mobile menu toggle
                document.addEventListener('DOMContentLoaded', function () {
                    const btn = document.getElementById('mobile-menu-button');
                    const menu = document.getElementById('mobile-menu');
                    btn.addEventListener('click', function () {
                        menu.classList.toggle('hidden');
                    });
                });
            </script>
        </header>
        <main class="py-8">
            @yield('content')
        </main>
    </body>
</html>