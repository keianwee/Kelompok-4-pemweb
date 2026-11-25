<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Reservasi Hotel California</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        h2 { margin-bottom: 4px; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #0f172a; color: #fff; padding: 7px; text-align: left; }
        td { border-bottom: 1px solid #cbd5e1; padding: 6px 7px; }
        .summary { margin-top: 15px; text-align: right; font-size: 13px; font-weight: bold; color: #b45309; }
    </style>
</head>
<body>
    <h2>LAPORAN TRANSAKSI RESERVASI — HOTEL CALIFORNIA</h2>
    <div>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Malam</th>
                <th>Status</th>
                <th style="text-align: right;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td>{{ $b->booking_code }}</td>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->room->roomType->name }} (#{{ $b->room->room_number }})</td>
                <td>{{ $b->check_in }}</td>
                <td>{{ $b->check_out }}</td>
                <td>{{ $b->total_nights }}</td>
                <td>{{ strtoupper($b->status) }}</td>
                <td style="text-align: right;">{{ number_format($b->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">Total Pendapatan Bersih: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
</body>
</html>