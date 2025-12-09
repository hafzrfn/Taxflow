<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM Pajak - Sistem Informasi Manajemen Pajak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen">

    <!-- Modern Navigation -->
    <nav class="glass fixed top-0 left-0 right-0 z-50 border-b border-white/20">
        <div class="container-custom">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-primary flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        SP
                    </div>
                    <div class="hidden md:block">
                        <div class="font-bold text-gray-900">SIM Pajak</div>
                        <div class="text-xs text-gray-600">Sistem Informasi Manajemen Pajak</div>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Home</a>

                    @auth
                        @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
                            <a href="{{ route('spt.form') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">e-Filing</a>
                            <a href="{{ route('payments.list') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Pembayaran</a>
                        @endif

                        <a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Dashboard</a>

                        @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
                            <a href="{{ route('profile.edit') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Profile</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="btn btn-secondary btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar Sekarang</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-40 lg:hidden hidden">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" id="mobile-menu-overlay"></div>
        <div
            class="fixed right-0 top-0 bottom-0 w-64 glass-dark p-6 transform translate-x-0 transition-transform duration-300">
            <div class="flex flex-col gap-4 mt-20">
                <a href="{{ route('home') }}" class="text-white hover:text-blue-300 transition-colors">Home</a>
                @auth
                    @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
                        <a href="{{ route('spt.form') }}" class="text-white hover:text-blue-300 transition-colors">e-Filing</a>
                        <a href="{{ route('payments.list') }}"
                            class="text-white hover:text-blue-300 transition-colors">Pembayaran</a>
                    @endif
                    <a href="{{ route('dashboard') }}"
                        class="text-white hover:text-blue-300 transition-colors">Dashboard</a>
                    @if(!(Auth::user() && Auth::user()->email === 'admin@demo.test'))
                        <a href="{{ route('profile.edit') }}"
                            class="text-white hover:text-blue-300 transition-colors">Profile</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger w-full">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost w-full">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary w-full">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl animate-float"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="container-custom relative z-10">
            <div class="max-w-4xl mx-auto text-center animate-slide-up">
        <h1 class="text-5xl md:text-7xl font-bold mb-3">
          <span class="text-gradient">TaxFlow</span>
        </h1>
        <p class="text-2xl md:text-3xl text-gray-900 font-semibold mb-6">
          Smooth, efficient tax management
        </p>
        <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
          Layanan digital pelaporan dan pembayaran pajak. E-filing, e-Billing, verifikasi identitas dan monitoring
        </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up stagger-1">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar Sekarang
                        </a>
                    @endauth
                    <a href="#features" class="btn btn-secondary btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section bg-white/50">
        <div class="container-custom">
            <div class="text-center mb-16 animate-slide-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="text-gradient">Fitur Unggulan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Kemudahan dan kecepatan dalam mengelola pajak Anda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card card-hover animate-slide-up stagger-1">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-primary flex items-center justify-center text-white mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Pendaftaran Online</h3>
                    <p class="text-gray-600">Registrasi wajib pajak dengan verifikasi identitas yang cepat dan aman</p>
                </div>

                <!-- Feature 2 -->
                <div class="card card-hover animate-slide-up stagger-2">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-success flex items-center justify-center text-white mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">E-Filing</h3>
                    <p class="text-gray-600">Kirim SPT secara online dengan validasi otomatis dan bukti penerimaan
                        digital</p>
                </div>

                <!-- Feature 3 -->
                <div class="card card-hover animate-slide-up stagger-3">
                    <div
                        class="w-16 h-16 rounded-2xl bg-gradient-accent flex items-center justify-center text-white mb-6 shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">E-Billing</h3>
                    <p class="text-gray-600">Pembayaran pajak terintegrasi dengan payment gateway yang aman</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section bg-gradient-primary text-white">
        <div class="container-custom">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="animate-scale-in stagger-1">
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <div class="text-blue-100">Digital & Paperless</div>
                </div>
                <div class="animate-scale-in stagger-2">
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <div class="text-blue-100">Akses Kapan Saja</div>
                </div>
                <div class="animate-scale-in stagger-3">
                    <div class="text-5xl font-bold mb-2">Aman</div>
                    <div class="text-blue-100">Terenkripsi & Terpercaya</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container-custom">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-gradient-primary flex items-center justify-center text-white font-bold">
                            SP
                        </div>
                        <div class="font-bold text-white">SIM Pajak</div>
                    </div>
                    <p class="text-sm">Sistem Informasi Manajemen Pajak yang modern dan terpercaya</p>
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
                        <p>Email: info@simpajak.go.id</p>
                        <p>Telp: (021) 1234-5678</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} SIM Pajak. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

        mobileMenuBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenuOverlay?.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>

</html>