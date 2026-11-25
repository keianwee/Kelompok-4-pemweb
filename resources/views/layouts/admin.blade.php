<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel — Hotel California')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery, DataTables, Summernote & Chart.js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 flex min-h-screen">

    <!-- Sidebar Admin -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0">
        <div>
            <div class="p-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white tracking-tight">
                    Hotel <span class="text-amber-500">California</span>
                </a>
                <p class="text-xs text-slate-400 mt-1">Back-Office Management</p>
            </div>

            <nav class="p-4 space-y-1.5">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800' }}">
                    Dashboard & Statistik
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.bookings.*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800' }}">
                    Data Reservasi & Laporan
                </a>
                <a href="{{ route('admin.room-types.index') }}" class="block px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.room-types.*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800' }}">
                    Tipe Kamar
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="block px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.rooms.*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800' }}">
                    Daftar Unit Kamar
                </a>
                <a href="{{ route('admin.backup.index') }}" class="block px-4 py-2.5 rounded-xl text-sm {{ request()->routeIs('admin.backup.*') ? 'bg-amber-600 text-white font-semibold' : 'hover:bg-slate-800' }}">
                    Backup & Restore
                </a>

                <!-- Menu Public REST API -->
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <p class="px-4 text-[10px] font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Public REST API</p>
                    <a href="{{ url('/api/rooms/availability') }}" target="_blank" class="block px-4 py-2 rounded-xl text-xs text-amber-400 hover:bg-slate-800">
                        API Ketersediaan Kamar &nearr;
                    </a>
                    <a href="{{ url('/api/rooms/popular') }}" target="_blank" class="block px-4 py-2 rounded-xl text-xs text-amber-400 hover:bg-slate-800">
                        API Kamar Terpopuler &nearr;
                    </a>
                </div>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('home') }}" class="block text-center text-xs text-slate-400 hover:text-white py-1.5">
                &larr; Lihat Web Tamu
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-slate-800 hover:bg-rose-700 text-white text-xs font-medium py-2.5 rounded-xl transition">
                    Logout ({{ auth()->user()->name }})
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama Admin -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center">
            <h1 class="text-lg font-bold text-slate-900">@yield('header', 'Admin Panel')</h1>
            <span class="text-xs text-slate-500">{{ now()->format('l, d F Y') }}</span>
        </header>

        <main class="p-8 flex-1">
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
    </div>

    @stack('scripts')
</body>
</html>