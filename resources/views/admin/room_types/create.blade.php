@extends('layouts.admin')

@section('title', 'Tambah Tipe Kamar')

@section('content')
<div class="max-w-2xl bg-white p-6 rounded-xl shadow-sm border border-stone-200">
    <h2 class="text-xl font-bold text-stone-800 mb-4">Tambah Tipe Kamar Baru</h2>

    <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nama Tipe Kamar</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Harga per Malam (Rp)</label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" required min="0" class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kapasitas Tamu (Orang)</label>
                <input type="number" name="capacity" value="{{ old('capacity', 2) }}" required min="1" class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Fasilitas</label>
            <input type="text" name="facilities" value="{{ old('facilities') }}" placeholder="Contoh: WiFi, AC, TV, Sarapan" class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-stone-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Foto Kamar</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm">
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('admin.room-types.index') }}" class="px-4 py-2 bg-stone-200 text-stone-800 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium">Simpan</button>
        </div>
    </form>
</div>
@endsection