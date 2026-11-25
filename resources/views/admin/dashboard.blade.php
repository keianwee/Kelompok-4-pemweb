@extends('layouts.admin')
@section('title', 'Dashboard — Hotel California')
@section('header', 'Dashboard & Statistik Okupansi')

@section('content')
<!-- Kartu Ringkasan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold uppercase text-slate-400">Total Unit Kamar</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalRooms }} Unit</p>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold uppercase text-emerald-600">Kamar Tersedia (Kosong)</p>
        <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $availableRooms }} Unit</p>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold uppercase text-amber-600">Kamar Terisi</p>
        <p class="text-2xl font-bold text-amber-700 mt-1">{{ $occupiedRooms }} Unit</p>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold uppercase text-slate-400">Total Pendapatan</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<!-- 2 Grafik Chart.js -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Grafik Pendapatan Bulanan (Rp)</h3>
        <canvas id="revenueChart" height="120"></canvas>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-4">Tren Tipe Kamar Terlaris</h3>
        <canvas id="popularChart" height="220"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik 1: Pendapatan Bulanan
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartMonths) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartRevenues) !!},
                backgroundColor: '#b45309',
                borderRadius: 8
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Grafik 2: Tipe Kamar Terlaris
    new Chart(document.getElementById('popularChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($typeLabels) !!},
            datasets: [{
                data: {!! json_encode($typeCounts) !!},
                backgroundColor: ['#0f172a', '#b45309', '#d97706', '#64748b']
            }]
        },
        options: { responsive: true }
    });
</script>
@endpush