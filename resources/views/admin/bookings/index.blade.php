@extends('layouts.admin')
@section('title', 'Data Reservasi — Hotel California')
@section('header', 'Data Reservasi & Laporan Keuangan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <form method="GET" class="flex flex-wrap items-end justify-between gap-4 mb-6 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="flex flex-wrap gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Filter Tipe Kamar</label>
                <select name="room_type_id" class="text-xs border border-slate-300 rounded-lg px-3 py-2 bg-white">
                    <option value="">Semua Tipe Kamar</option>
                    @foreach($roomTypes as $rt)
                        <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Filter Bulan Check-In</label>
                <input type="month" name="month" class="text-xs border border-slate-300 rounded-lg px-3 py-2 bg-white">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" formaction="{{ route('admin.bookings.export-excel') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-medium px-4 py-2.5 rounded-xl transition">
                Download Excel (.xlsx)
            </button>
            <button type="submit" formaction="{{ route('admin.bookings.export-pdf') }}" class="bg-rose-700 hover:bg-rose-800 text-white text-xs font-medium px-4 py-2.5 rounded-xl transition">
                Download Laporan PDF
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table id="bookingsTable" class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3">Kode</th>
                    <th class="px-3 py-3">Tamu</th>
                    <th class="px-3 py-3">Kamar</th>
                    <th class="px-3 py-3">Check-In / Out</th>
                    <th class="px-3 py-3">Total</th>
                    <th class="px-3 py-3">Status</th>
                    <th class="px-3 py-3 text-right">Invoice</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($bookings as $b)
                <tr>
                    <td class="px-3 py-3 font-mono font-bold text-xs">{{ $b->booking_code }}</td>
                    <td class="px-3 py-3">
                        <span class="font-medium text-slate-900 block">{{ $b->user->name }}</span>
                        <span class="text-xs text-slate-400">{{ $b->user->phone }}</span>
                    </td>
                    <td class="px-3 py-3">{{ $b->room->roomType->name }} (#{{ $b->room->room_number }})</td>
                    <td class="px-3 py-3 text-xs">{{ $b->check_in }} s/d {{ $b->check_out }} ({{ $b->total_nights }}m)</td>
                    <td class="px-3 py-3 font-semibold text-amber-700">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                    <td class="px-3 py-3">
                        <form action="{{ route('admin.bookings.status', $b) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs border border-slate-300 rounded-lg px-2 py-1 bg-white">
                                <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="checked_in" {{ $b->status === 'checked_in' ? 'selected' : '' }}>Checked-In</option>
                                <option value="checked_out" {{ $b->status === 'checked_out' ? 'selected' : '' }}>Checked-Out</option>
                                <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-3 py-3 text-right">
                        <a href="{{ route('bookings.invoice', $b) }}" class="text-xs font-medium text-slate-700 hover:text-amber-700 underline">PDF</a>
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
        $('#bookingsTable').DataTable({ order: [[0, 'desc']] });
    });
</script>
@endpush