<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel California')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Navbar Tamu -->
    <nav class="bg-white/90 backdrop-blur border-b border-stone-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-slate-900">
                Hotel <span class="text-amber-700">California</span>
            </a>

            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-amber-700 font-medium">Beranda</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-amber-700 font-medium">Dashboard Admin</a>
                    @else
                        <a href="{{ route('guest.bookings.index') }}" class="text-slate-600 hover:text-amber-700 font-medium">Reservasi Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-slate-900 hover:bg-rose-700 text-white text-xs font-medium px-4 py-2 rounded-xl transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-amber-700 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-amber-700 hover:bg-amber-800 text-white text-xs font-medium px-4 py-2.5 rounded-xl transition">
                        Daftar Tamu
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main class="max-w-6xl w-full mx-auto px-6 py-10 flex-1">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer dengan Menu Public REST API -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-8">
        <div class="max-w-6xl mx-auto px-6 flex flex-wrap justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} Hotel California — Minimalist Urban Sanctuary.</p>
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-slate-500 font-semibold">Public JSON API:</span>
                <a href="{{ url('/api/rooms/availability') }}" target="_blank" class="text-amber-500 hover:underline">
                    GET /api/rooms/availability &nearr;
                </a>
                <a href="{{ url('/api/rooms/popular') }}" target="_blank" class="text-amber-500 hover:underline">
                    GET /api/rooms/popular &nearr;
                </a>
            </div>
        </div>
    </footer>

</body>
</html>