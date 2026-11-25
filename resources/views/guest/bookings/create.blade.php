@extends('layouts.app')
@section('title', 'Pesan Kamar — Hotel California')

@section('content')
@php
    $totalAvailable = $roomTypes->sum('available_rooms_count');
@endphp

<div class="max-w-2xl mx-auto bg-white rounded-3xl border border-stone-200 p-8 shadow-sm">
    <h1 class="text-2xl font-bold text-slate-900 mb-1">Formulir Reservasi Kamar</h1>
    <p class="text-xs text-slate-500 mb-6">Pilih tipe kamar dan tanggal menginap Anda di Hotel California.</p>

    @if($totalAvailable === 0)
        <div class="mb-6 bg-rose-50 border border-rose-300 text-rose-800 p-4 rounded-2xl flex items-start gap-3">
            <span class="text-lg leading-none">&#9888;</span>
            <div class="text-xs">
                <p class="font-bold text-sm mb-0.5">Semua Kamar Penuh (0 Tersedia)</p>
                <p>Mohon maaf, seluruh unit kamar di Hotel California sedang terisi penuh. Silakan hubungi resepsionis atau cek kembali beberapa saat lagi.</p>
            </div>
        </div>
    @endif

    <div id="soldOutAlert" class="hidden mb-5 bg-rose-50 border border-rose-300 text-rose-800 p-3.5 rounded-2xl text-xs font-medium">
        &#9888; Tipe kamar yang Anda pilih sedang penuh (0 kamar tersedia). Silakan pilih tipe kamar lain yang masih tersedia.
    </div>

    <form action="{{ route('guest.bookings.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Kamar</label>
            <select id="roomTypeSelect" name="room_type_id" required class="w-full text-sm border border-stone-300 rounded-xl px-4 py-3 bg-white">
                @foreach($roomTypes as $rt)
                    <option value="{{ $rt->id }}"
                        data-available="{{ $rt->available_rooms_count }}"
                        {{ (old('room_type_id', $selectedTypeId) == $rt->id) ? 'selected' : '' }}>
                        {{ $rt->name }} — Rp {{ number_format($rt->price_per_night, 0, ',', '.') }}/malam
                        ({{ $rt->available_rooms_count > 0 ? $rt->available_rooms_count . ' tersedia' : 'HABIS / 0 tersedia' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Check-In</label>
                <input type="date" name="check_in" value="{{ old('check_in', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required class="w-full text-sm border border-stone-300 rounded-xl px-4 py-3">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Check-Out</label>
                <input type="date" name="check_out" value="{{ old('check_out', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full text-sm border border-stone-300 rounded-xl px-4 py-3">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Khusus (Opsional)</label>
            <textarea name="notes" rows="3" placeholder="Contoh: Kamar bebas asap rokok, check-in malam..." class="w-full text-sm border border-stone-300 rounded-xl px-4 py-3">{{ old('notes') }}</textarea>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3 rounded-xl">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('home') }}" class="px-5 py-3 rounded-xl text-xs font-medium text-slate-600 hover:bg-stone-100">Batal</a>
            <button id="submitBookingBtn" type="submit" class="bg-amber-700 hover:bg-amber-800 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs font-semibold px-6 py-3 rounded-xl transition">
                Konfirmasi Pemesanan
            </button>
        </div>
    </form>
</div>

<script>
    const selectEl = document.getElementById('roomTypeSelect');
    const alertEl = document.getElementById('soldOutAlert');
    const submitBtn = document.getElementById('submitBookingBtn');

    function checkAvailability() {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const available = parseInt(selectedOption.getAttribute('data-available') || '0', 10);

        if (available < 1) {
            alertEl.classList.remove('hidden');
            submitBtn.disabled = true;
        } else {
            alertEl.classList.add('hidden');
            submitBtn.disabled = false;
        }
    }

    selectEl.addEventListener('change', checkAvailability);
    checkAvailability();
</script>
@endsection