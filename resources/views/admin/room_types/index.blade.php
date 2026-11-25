@extends('layouts.admin')

@section('title', 'Kelola Tipe Kamar')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-stone-800">Daftar Tipe Kamar</h2>
        <p class="text-sm text-stone-500">Atur kategori kamar, tarif per malam, kapasitas, dan fasilitas.</p>
    </div>
    <a href="{{ route('admin.room-types.create') }}" class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg">
        + Tambah Tipe Kamar
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-stone-50 text-stone-600 border-b border-stone-200">
            <tr>
                <th class="px-6 py-3">Foto</th>
                <th class="px-6 py-3">Nama Tipe</th>
                <th class="px-6 py-3">Harga / Malam</th>
                <th class="px-6 py-3">Kapasitas</th>
                <th class="px-6 py-3">Jumlah Unit</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-200">
            @forelse($roomTypes as $type)
            <tr>
                <td class="px-6 py-3">
                    @if($type->image)
                        <img src="{{ asset('storage/' . $type->image) }}" alt="{{ $type->name }}" class="w-16 h-12 object-cover rounded">
                    @else
                        <div class="w-16 h-12 bg-stone-200 rounded flex items-center justify-center text-xs text-stone-500">No Img</div>
                    @endif
                </td>
                <td class="px-6 py-3">
                    <div class="font-semibold text-stone-800">{{ $type->name }}</div>
                    <div class="text-xs text-stone-500">{{ Str::limit($type->facilities, 50) }}</div>
                </td>
                <td class="px-6 py-3 font-medium">Rp {{ number_format($type->price_per_night, 0, ',', '.') }}</td>
                <td class="px-6 py-3">{{ $type->capacity }} Orang</td>
                <td class="px-6 py-3">{{ $type->rooms_count }} Unit</td>
                <td class="px-6 py-3 text-right space-x-2">
                    <a href="{{ route('admin.room-types.edit', $type) }}" class="px-3 py-1.5 bg-stone-200 hover:bg-stone-300 text-stone-800 rounded text-xs font-medium">Edit</a>
                    <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tipe kamar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-stone-400">Belum ada data tipe kamar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection