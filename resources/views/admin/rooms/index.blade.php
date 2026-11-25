@extends('layouts.admin')
@section('title', 'Unit Kamar — Hotel California')
@section('header', 'Manajemen Unit & Status Kamar')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah Unit Kamar -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-fit">
        <h3 class="font-bold text-slate-800 mb-4">Tambah Nomor Kamar</h3>
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tipe Kamar</label>
                <select name="room_type_id" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Nomor Kamar</label>
                <input type="text" name="room_number" required placeholder="Misal: 104" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status Awal</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm">
                    <option value="available">Available (Kosong / Siap)</option>
                    <option value="occupied">Occupied (Terisi)</option>
                    <option value="maintenance">Maintenance (Perbaikan)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-slate-900 hover:bg-amber-700 text-white py-2.5 rounded-xl text-sm font-medium transition">
                + Tambah Unit
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Kamar -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <table id="roomsTable" class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No. Kamar</th>
                    <th class="px-4 py-3">Tipe Kamar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Ubah Status / Hapus</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($rooms as $room)
                <tr>
                    <td class="px-4 py-3 font-bold text-slate-900">#{{ $room->room_number }}</td>
                    <td class="px-4 py-3">{{ $room->roomType->name }}</td>
                    <td class="px-4 py-3">
                        @if($room->status === 'available')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Tersedia</span>
                        @elseif($room->status === 'occupied')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Terisi</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Maintenance</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="inline-flex items-center gap-1">
                            @csrf @method('PUT')
                            <input type="hidden" name="room_type_id" value="{{ $room->room_type_id }}">
                            <input type="hidden" name="room_number" value="{{ $room->room_number }}">
                            <select name="status" onchange="this.form.submit()" class="text-xs border border-slate-300 rounded-lg px-2 py-1">
                                <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline ml-1" onsubmit="return confirm('Hapus nomor kamar ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:underline px-1">Hapus</button>
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
        $('#roomsTable').DataTable();
    });
</script>
@endpush