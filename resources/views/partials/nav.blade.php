<nav class="glass sticky top-0 z-50 border-b border-white/20 shadow-lg">
  <div class="container-custom">
    <div class="flex items-center justify-between h-16">
      <a href="{{ url('/') }}" class="flex items-center gap-3 group">
        <img src="{{ asset('images/taxflow-logo.png') }}" alt="TaxFlow"
          class="h-10 w-auto group-hover:scale-105 transition-transform duration-300">
      </a>

      <div class="flex items-center gap-4">
        {{-- Show Home link only for guests --}}
        @guest
          <a href="{{ route('home') }}"
            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors hidden sm:inline">Home</a>
        @endguest

        {{-- Hide e-Filing and Riwayat links for admin user --}}
        @auth
          @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
            <a href="{{ route('spt.form') }}"
              class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors hidden sm:inline">e-Filing</a>
            <a href="{{ route('payments.list') }}"
              class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors hidden sm:inline">Riwayat</a>
          @endif

          <a href="{{ route('dashboard') }}"
            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Dashboard</a>
          {{-- Hide Profile link for admin --}}
          @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
            <a href="{{ route('profile.edit') }}"
              class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Profile</a>
          @endif
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
          <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
        @endauth
      </div>
    </div>
  </div>
</nav>