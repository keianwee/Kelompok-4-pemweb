@extends('layouts.admin')
@section('title', 'Tipe Kamar — Hotel California')
@section('header', 'Manajemen Tipe Kamar')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-slate-500">Kelola kategori kamar, harga per malam, foto, dan deskripsi rich-text.</p>
        <a href="{{ route('admin.room-types.create') }}" class="bg-slate-900 hover:bg-amber-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition">
            + Tambah Tipe Kamar
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="roomTypesTable" class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Tipe Kamar</th>
                    <th class="px-4 py-3">Harga / Malam</th>
                    <th class="px-4 py-3">Kapasitas</th>
                    <th class="px-4 py-3">Jumlah Unit</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($roomTypes as $type)
                <tr>
                    <td class="px-4 py-3 font-semibold text-slate-900">
                        {{ $type->name }}
                        <span class="block text-xs font-normal text-slate-500 mt-0.5">{{ $type->facilities }}</span>
                    </td>
                    <td class="px-4 py-3 font-medium text-amber-700">Rp {{ number_format($type->price_per_night, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $type->capacity }} Orang</td>
                    <td class="px-4 py-3">{{ $type->rooms_count }} Kamar</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('admin.room-types.edit', $type) }}" class="inline-block px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 text-xs font-medium">Edit</a>
                        <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tipe kamar ini beserta seluruh unitnya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#roomTypesTable').DataTable();
    });
</script>
@endpush