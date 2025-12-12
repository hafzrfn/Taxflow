<footer class="bg-gray-900 text-gray-300 mt-16">
  <div class="container-custom py-12">
    <div class="grid md:grid-cols-3 gap-8 mb-8">
      <div>
        <div class="flex items-center gap-3 mb-4">
          <img src="{{ asset('images/taxflow-logo.png') }}" alt="TaxFlow" class="h-10 w-auto">
        </div>
        <p class="text-sm">Smooth, efficient tax management</p>
      </div>
      <div>
        <h4 class="font-bold text-white mb-4">Menu</h4>
        <div class="space-y-2 text-sm">
          <a href="{{ route('home') }}" class="block hover:text-white transition-colors">Home</a>
          <a href="{{ route('login') }}" class="block hover:text-white transition-colors">Login</a>
          <a href="{{ route('register') }}" class="block hover:text-white transition-colors">Daftar</a>
        </div>
      </div>
      <div>
        <h4 class="font-bold text-white mb-4">Kontak</h4>
        <div class="space-y-2 text-sm">
          <p>Email: info@taxflow.id</p>
          <p>Telp: (021) 1234-5678</p>
        </div>
      </div>
    </div>
    <div class="border-t border-gray-800 pt-8 text-center text-sm">
      <p>&copy; {{ date('Y') }} TaxFlow. All rights reserved.</p>
    </div>
  </div>
</footer>