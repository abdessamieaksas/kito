<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net" />
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS (or your custom CSS file) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Optional Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="font-sans antialiased bg-gray-100">
  <div class="flex">
    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main Content -->
    <div class="flex-1">
      <!-- Topbar -->
      @include('admin.navbar')

      <!-- Main Content Area -->
      <div class="p-6">
        <!-- Page Header -->
        @isset($header)
          <header class="bg-white shadow mb-6">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              {{ $header }}
            </div>
          </header>
        @endisset

        <!-- Page Content -->
        <main>
          {{ $slot }}
        </main>
      </div>
    </div>
  </div>
</body>

</html>
