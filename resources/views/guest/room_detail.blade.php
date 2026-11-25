@extends('layouts.app')
@section('title', $roomType->name . ' — Hotel California')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
    <a href="{{ route('home') }}" class="text-xs font-medium text-slate-500 hover:text-amber-700">&larr; Kembali ke Daftar Kamar</a>

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informasi Kamar -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-sm">
            <div class="h-72 bg-stone-200">
                @if($roomType->image)
                    <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-stone-800 to-amber-900 flex flex-col items-center justify-center text-white">
                        <span class="font-serif-brand text-3xl">{{ $roomType->name }}</span>
                        <span class="text-xs text-amber-300 tracking-widest uppercase mt-1">Hotel California</span>
                    </div>
                @endif
            </div>
            <div class="p-6 md:p-8">
                <div class="flex flex-wrap justify-between items-center gap-2 pb-4 border-b border-stone-100">
                    <h1 class="font-serif-brand text-2xl md:text-3xl font-bold text-slate-900">{{ $roomType->name }}</h1>
                    <p class="text-xl font-bold text-amber-700">Rp {{ number_format($roomType->price_per_night, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">/ malam</span></p>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 text-xs">
                    <span class="px-3 py-1 rounded-lg bg-stone-100 text-slate-700">Kapasitas: {{ $roomType->capacity }} Orang</span>
                    <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-medium">Tersedia: {{ $availableRooms->count() }} Unit</span>
                </div>

                <div class="mt-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Fasilitas Utama</h3>
                    <p class="text-sm text-slate-700">{{ $roomType->facilities }}</p>
                </div>

                <div class="mt-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Kamar</h3>
                    <!-- Render HTML dari WYSIWYG Editor -->
                    <div class="text-sm text-slate-600 leading-relaxed space-y-2 [&>ul]:list-disc [&>ul]:pl-5">
                        {!! $roomType->description !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Reservasi -->
        <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm h-fit">
            <h2 class="font-serif-brand text-xl font-bold text-slate-900 mb-1">Reservasi Kamar</h2>
            <p class="text-xs text-slate-500 mb-5">Konfirmasi instan & bukti booking PDF</p>

            @auth
                @if(auth()->user()->role === 'guest')
                    @if($availableRooms->count() > 0)
                    <form action="{{ route('guest.bookings.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tanggal Check-In</label>
                            <input type="date" name="check_in" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 rounded-xl border border-stone-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tanggal Check-Out</label>
                            <input type="date" name="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-3 py-2 rounded-xl border border-stone-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Catatan Khusus (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Misal: Check-in sore jam 15.00" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-sm"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-slate-900 hover:bg-amber-700 text-white font-medium py-3 rounded-xl text-sm transition">
                            Konfirmasi Pemesanan
                        </button>
                    </form>
                    @else
                        <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-xs">
                            Mohon maaf, seluruh unit kamar tipe ini sedang terisi. Silakan pilih tipe kamar lain.
                        </div>
                    @endif
                @else
                    <div class="p-4 rounded-xl bg-amber-50 text-amber-800 text-xs">
                        Anda sedang login sebagai <strong>Manajemen/Admin</strong>. Silakan login menggunakan akun Tamu untuk melakukan simulasi booking.
                    </div>
                @endif
            @else
                <div class="p-4 rounded-xl bg-stone-50 border border-stone-200 text-center space-y-3">
                    <p class="text-xs text-slate-600">Silakan masuk ke akun tamu terlebih dahulu untuk memesan kamar ini.</p>
                    <a href="{{ route('login') }}" class="block w-full bg-slate-900 text-white text-xs font-medium py-2.5 rounded-xl hover:bg-amber-700 transition">
                        Masuk untuk Memesan
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection