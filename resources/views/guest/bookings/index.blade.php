@extends('layouts.app')
@section('title', 'Reservasi Saya — Hotel California')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Riwayat Reservasi Saya</h1>
        <p class="text-xs text-slate-500">Pantau status pemesanan dan unduh bukti invoice PDF Anda.</p>
    </div>
    <a href="{{ route('guest.bookings.create') }}" class="bg-amber-700 hover:bg-amber-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
        + Pesan Kamar Lagi
    </a>
</div>

<div class="space-y-4">
    @forelse($bookings as $b)
        <div class="bg-white rounded-2xl border border-stone-200 p-6 flex flex-wrap justify-between items-center gap-4 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-mono text-xs font-bold bg-stone-100 px-2.5 py-1 rounded-lg">{{ $b->booking_code }}</span>
                    <span class="text-xs font-semibold uppercase px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ $b->status }}</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900">{{ $b->room->roomType->name }} — Kamar #{{ $b->room->room_number }}</h3>
                <p class="text-xs text-slate-500">Check-In: <strong>{{ $b->check_in }}</strong> &bull; Check-Out: <strong>{{ $b->check_out }}</strong> ({{ $b->total_nights }} malam)</p>
            </div>
            <div class="text-right">
                <span class="text-lg font-bold text-amber-700 block mb-2">Rp {{ number_format($b->total_price, 0, ',', '.') }}</span>
                <a href="{{ route('bookings.invoice', $b) }}" class="inline-block bg-slate-900 hover:bg-amber-700 text-white text-xs font-medium px-4 py-2 rounded-xl transition">
                    Download Invoice PDF
                </a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-10 text-center text-sm text-slate-500">
            Anda belum memiliki riwayat reservasi. <a href="{{ route('home') }}" class="text-amber-700 font-semibold underline">Pilih kamar sekarang</a>.
        </div>
    @endforelse
</div>
@endsection