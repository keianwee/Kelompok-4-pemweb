<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Reservasi — Hotel California</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        .header { border-bottom: 2px solid #b45309; padding-bottom: 10px; margin-bottom: 16px; }
        .header h1 { margin: 0; font-size: 18px; color: #0f172a; }
        .header p { margin: 2px 0 0; color: #64748b; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #0f172a; color: #ffffff; text-align: left; padding: 7px; font-size: 10px; }
        td { border-bottom: 1px solid #e2e8f0; padding: 7px; }
        .total-box { margin-top: 16px; text-align: right; font-size: 13px; font-weight: bold; color: #b45309; }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOTEL CALIFORNIA — LAPORAN RESERVASI & PENDAPATAN</h1>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i:s') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Tamu</th>
                <th>Tipe & No. Kamar</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Malam</th>
                <th>Status</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td><strong>{{ $b->booking_code }}</strong></td>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->room->roomType->name }} (#{{ $b->room->room_number }})</td>
                <td>{{ $b->check_in }}</td>
                <td>{{ $b->check_out }}</td>
                <td>{{ $b->total_nights }}</td>
                <td>{{ strtoupper($b->status) }}</td>
                <td>{{ number_format($b->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        Total Pendapatan Valid: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>
</body>
</html>