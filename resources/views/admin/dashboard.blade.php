@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-stone-800">Dashboard Ringkasan Hotel</h2>
    <p class="text-sm text-stone-500">Pantau ketersediaan kamar, reservasi, dan pendapatan secara real-time.</p>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-stone-200">
        <p class="text-xs font-medium text-stone-500 uppercase">Total Unit Kamar</p>
        <p class="text-3xl font-bold text-stone-800 mt-1">{{ $totalRooms }}</p>
        <p class="text-xs text-stone-500 mt-2">{{ $totalRoomTypes }} Kategori Tipe Kamar</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-stone-200">
        <p class="text-xs font-medium text-emerald-600 uppercase">Kamar Tersedia</p>
        <p class="text-3xl font-bold text-emerald-700 mt-1">{{ $availableRooms }}</p>
        <p class="text-xs text-stone-500 mt-2">Terisi: {{ $occupiedRooms }} | Perbaikan: {{ $maintenanceRooms }}</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-stone-200">
        <p class="text-xs font-medium text-amber-600 uppercase">Total Reservasi</p>
        <p class="text-3xl font-bold text-amber-700 mt-1">{{ $totalBookings }}</p>
        <p class="text-xs text-stone-500 mt-2">Pending: {{ $pendingBookings }} | Aktif: {{ $confirmedBookings }}</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-stone-200">
        <p class="text-xs font-medium text-stone-500 uppercase">Total Pendapatan</p>
        <p class="text-2xl font-bold text-stone-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-xs text-stone-500 mt-2">{{ $totalGuests }} Tamu Terdaftar</p>
    </div>
</div>

<!-- Tabel Reservasi Terbaru -->
<div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-stone-200 flex justify-between items-center">
        <h3 class="font-semibold text-stone-800">5 Reservasi Terbaru</h3>
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-amber-700 hover:underline font-medium">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-stone-50 text-stone-600 border-b border-stone-200">
                <tr>
                    <th class="px-6 py-3">Tamu</th>
                    <th class="px-6 py-3">Kamar</th>
                    <th class="px-6 py-3">Check-in / Out</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-200">
                @forelse($recentBookings as $booking)
                <tr>
                    <td class="px-6 py-3 font-medium">{{ $booking->user->name ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $booking->room->room_number ?? '-' }} ({{ $booking->room->roomType->name ?? '-' }})</td>
                    <td class="px-6 py-3">{{ $booking->check_in }} s/d {{ $booking->check_out }}</td>
                    <td class="px-6 py-3">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 uppercase">
                            {{ $booking->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-stone-400">Belum ada data reservasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection