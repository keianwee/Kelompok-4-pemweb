<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Hotel California</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 text-stone-800 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-stone-900 text-stone-100 flex flex-col justify-between min-h-screen">
        <div>
            <div class="p-6 border-b border-stone-800">
                <h1 class="text-xl font-bold tracking-wide text-amber-400">Hotel California</h1>
                <p class="text-xs text-stone-400 mt-1">Admin Back Office</p>
            </div>
            <nav class="p-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-amber-600 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.room-types.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.room-types.*') ? 'bg-amber-600 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800' }}">
                    Tipe Kamar
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.rooms.*') ? 'bg-amber-600 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800' }}">
                    Unit Kamar
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-amber-600 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800' }}">
                    Kelola Reservasi
                </a>
                <a href="{{ route('admin.backup.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.backup.*') ? 'bg-amber-600 text-white font-semibold' : 'text-stone-300 hover:bg-stone-800' }}">
                    Backup & Restore
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-stone-800">
            <a href="{{ route('home') }}" class="block text-xs text-stone-400 hover:text-white mb-3">&larr; Lihat Halaman Tamu</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>