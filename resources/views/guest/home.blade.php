@extends('layouts.app')
@section('title', 'Hotel California — Minimalist Urban Sanctuary')

@section('content')
<!-- Hero Section -->
<section class="relative rounded-3xl overflow-hidden mb-14 shadow-lg bg-slate-900">
    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80"
         alt="Hotel California Lobby"
         class="w-full h-[420px] object-cover opacity-55">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/40 to-transparent flex flex-col justify-end p-8 md:p-12">
        <span class="text-xs font-semibold uppercase tracking-widest text-amber-400 mb-2">Minimalist Urban Sanctuary</span>
        <h1 class="text-3xl md:text-5xl font-bold text-white max-w-2xl leading-tight mb-4">
            Ketenangan Menginap di Jantung Kota
        </h1>
        <p class="text-sm text-slate-200 max-w-xl mb-6">
            Nikmati pengalaman menginap modern dengan kamar berdesain hangat, fasilitas premium, dan layanan reservasi instan.
        </p>
        <div>
            <a href="#kamar" class="inline-block bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-6 py-3.5 rounded-xl transition">
                Jelajahi Pilihan Kamar &darr;
            </a>
        </div>
    </div>
</section>

<!-- Galeri Suasana Hotel -->
<section class="mb-14">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-2xl overflow-hidden h-52 shadow-sm">
            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80" alt="Kolam Renang Hotel" class="w-full h-full object-cover hover:scale-105 transition duration-500">
        </div>
        <div class="rounded-2xl overflow-hidden h-52 shadow-sm">
            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80" alt="Lounge & Restoran" class="w-full h-full object-cover hover:scale-105 transition duration-500">
        </div>
        <div class="rounded-2xl overflow-hidden h-52 shadow-sm">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80" alt="Suasana Malam" class="w-full h-full object-cover hover:scale-105 transition duration-500">
        </div>
    </div>
</section>

<!-- Daftar Tipe Kamar -->
<section id="kamar">
    <div class="flex flex-wrap justify-between items-end mb-8">
        <div>
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-700">Akomodasi Kami</span>
            <h2 class="text-2xl font-bold text-slate-900">Pilihan Tipe Kamar</h2>
        </div>
        <p class="text-xs text-slate-500">Ketersediaan unit diperbarui secara real-time</p>
    </div>

    @php
        $roomImages = [
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($roomTypes as $index => $type)
            <div class="bg-white rounded-3xl border border-stone-200 overflow-hidden shadow-sm flex flex-col justify-between">
                <div>
                    <div class="relative h-56 bg-slate-200">
                        <img src="{{ $roomImages[$index % count($roomImages)] }}" alt="{{ $type->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-4 right-4 text-xs font-bold px-3 py-1.5 rounded-full {{ $type->available_rooms_count > 0 ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }}">
                            {{ $type->available_rooms_count > 0 ? 'Tersedia ' . $type->available_rooms_count . ' Kamar' : 'Habis (0 Tersedia)' }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <h3 class="text-xl font-bold text-slate-900">{{ $type->name }}</h3>
                            <div class="text-right shrink-0">
                                <span class="text-lg font-bold text-amber-700">Rp {{ number_format($type->price_per_night, 0, ',', '.') }}</span>
                                <span class="block text-[11px] text-slate-400">/ malam</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 mb-3">Kapasitas Maksimal: <strong>{{ $type->capacity }} Orang</strong> &bull; {{ $type->facilities }}</p>
                        <div class="text-xs text-slate-600 leading-relaxed mb-5">
                            {!! $type->description !!}
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    @if($type->available_rooms_count > 0)
                        <a href="{{ route('guest.bookings.create', ['room_type_id' => $type->id]) }}"
                           class="block text-center bg-slate-900 hover:bg-amber-700 text-white text-xs font-semibold py-3.5 rounded-xl transition">
                            Pesan Sekarang ({{ $type->available_rooms_count }} Tersedia)
                        </a>
                    @else
                        <button type="button"
                                onclick="alert('Maaf, seluruh unit untuk tipe kamar {{ $type->name }} saat ini sudah penuh (0 kamar tersedia). Silakan pilih tipe kamar lain.')"
                                class="w-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold py-3.5 rounded-xl cursor-not-allowed">
                            &#9888; Kamar Penuh (0 Tersedia)
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection