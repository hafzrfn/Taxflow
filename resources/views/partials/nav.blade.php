<nav class="bg-white shadow-sm">
  <div class="container mx-auto px-4 py-3 flex items-center justify-between">
    <a href="{{ url('/') }}" class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-[var(--brand)] flex items-center justify-center text-white font-bold">SP</div>
      <div class="hidden md:block">
        <div class="font-semibold">{{ config('app.name', 'SIM Pajak') }}</div>
        <div class="text-xs text-gray-500">Sistem Informasi Manajemen Pajak</div>
      </div>
    </a>

    <div class="flex items-center gap-4">
      <a href="{{ route('home') }}" class="text-sm text-gray-700 hidden sm:inline">Home</a>
      <a href="{{ route('spt.form') }}" class="text-sm text-gray-700 hidden sm:inline">e-Filing</a>
      <a href="{{ route('payments.list') }}" class="text-sm text-gray-700 hidden sm:inline">Pembayaran</a>

      @auth
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-700">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button class="ml-2 text-sm text-red-600">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
      @endauth
    </div>
  </div>
</nav>
