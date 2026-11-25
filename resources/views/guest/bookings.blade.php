@extends('layouts.app')
@section('title', 'Reservasi Saya — Hotel California')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
    <div class="mb-6">
        <h1 class="font-serif-brand text-2xl md:text-3xl font-bold text-slate-900">Riwayat Reservasi Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Unduh bukti reservasi resmi (PDF) untuk ditunjukkan saat check-in di resepsionis.</p>
    </div>

    <div class="space-y-4">
        @forelse($bookings as $booking)
        <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-mono font-bold px-2.5 py-1 rounded bg-stone-100 text-slate-800">{{ $booking->booking_code }}</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 uppercase">{{ $booking->status }}</span>
                </div>
                <h3 class="font-serif-brand text-lg font-bold text-slate-900 mt-2">
                    {{ $booking->room->roomType->name }} <span class="text-sm font-sans font-normal text-slate-500">(Kamar #{{ $booking->room->room_number }})</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">
                    Check-in: <strong>{{ $booking->check_in }}</strong> &bull; Check-out: <strong>{{ $booking->check_out }}</strong> ({{ $booking->total_nights }} Malam)
                </p>
            </div>

            <div class="flex items-center justify-between md:flex-col md:items-end gap-2 border-t md:border-t-0 pt-3 md:pt-0 border-stone-100">
                <p class="text-base font-bold text-amber-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <a href="{{ route('bookings.invoice', $booking) }}" class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-amber-700 text-white text-xs font-medium px-4 py-2 rounded-xl transition">
                    Cetak Invoice PDF
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-stone-200 p-10 text-center">
            <p class="text-slate-500 text-sm">Anda belum memiliki riwayat pemesanan kamar.</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 bg-slate-900 text-white text-xs font-medium px-5 py-2.5 rounded-xl">Cari Kamar Sekarang</a>
        </div>
        @endforelse
    </div>
</div>
@endsection