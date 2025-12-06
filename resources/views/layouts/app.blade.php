<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', config('app.name'))</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
  @include('partials.nav')

  <main class="min-h-screen py-8">
    <div class="container mx-auto px-4">
      @if(session('success'))
        <div class="mb-4">
          <div class="rounded p-3 bg-green-100 text-green-800">{{ session('success') }}</div>
        </div>
      @endif
      @if(session('error'))
        <div class="mb-4">
          <div class="rounded p-3 bg-red-100 text-red-800">{{ session('error') }}</div>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  @include('partials.footer')
</body>
</html>
