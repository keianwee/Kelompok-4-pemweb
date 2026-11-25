@extends('layouts.admin')

@section('title', 'Kelola Unit Kamar')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-stone-800">Manajemen Unit Kamar</h2>
    <p class="text-sm text-stone-500">Tambah nomor kamar baru dan ubah status ketersediaan setiap unit.</p>
</div>

<!-- Form Tambah Kamar Cepat -->
<div class="bg-white p-5 rounded-xl shadow-sm border border-stone-200 mb-6">
    <h3 class="font-semibold text-sm text-stone-700 mb-3">Tambah Unit Kamar Baru</h3>
    <form action="{{ route('admin.rooms.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        @csrf
        <input type="text" name="room_number" placeholder="No. Kamar (mis: 101)" required class="border border-stone-300 rounded-lg px-3 py-2 text-sm">
        <select name="room_type_id" required class="border border-stone-300 rounded-lg px-3 py-2 text-sm">
            <option value="">-- Pilih Tipe Kamar --</option>
            @foreach($roomTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <input type="number" name="floor" placeholder="Lantai (opsional)" min="1" class="border border-stone-300 rounded-lg px-3 py-2 text-sm">
        <select name="status" required class="border border-stone-300 rounded-lg px-3 py-2 text-sm">
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            <option value="maintenance">Maintenance</option>
        </select>
        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white rounded-lg px-4 py-2 text-sm font-medium">
            + Tambah Kamar
        </button>
    </form>
</div>

<!-- Daftar Unit Kamar -->
<div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-stone-50 text-stone-600 border-b border-stone-200">
            <tr>
                <th class="px-6 py-3">No. Kamar</th>
                <th class="px-6 py-3">Tipe Kamar</th>
                <th class="px-6 py-3">Lantai</th>
                <th class="px-6 py-3">Status & Edit Cepat</th>
                <th class="px-6 py-3 text-right">Hapus</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-200">
            @forelse($rooms as $room)
            <tr>
                <td class="px-6 py-3 font-bold">{{ $room->room_number }}</td>
                <td class="px-6 py-3">{{ $room->roomType->name ?? '-' }}</td>
                <td class="px-6 py-3">{{ $room->floor ?? '-' }}</td>
                <td class="px-6 py-3">
                    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="room_number" value="{{ $room->room_number }}">
                        <input type="hidden" name="room_type_id" value="{{ $room->room_type_id }}">
                        <input type="hidden" name="floor" value="{{ $room->floor }}">
                        <select name="status" class="border border-stone-300 rounded px-2.5 py-1 text-xs">
                            <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        <button type="submit" class="px-2.5 py-1 bg-stone-800 hover:bg-stone-900 text-white rounded text-xs">Simpan</button>
                    </form>
                </td>
                <td class="px-6 py-3 text-right">
                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kamar {{ $room->room_number }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-stone-400">Belum ada unit kamar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection