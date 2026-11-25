<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->booking_code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1e293b; }
        .box { border: 1px solid #cbd5e1; padding: 24px; border-radius: 8px; }
        .top { border-bottom: 2px solid #b45309; padding-bottom: 12px; margin-bottom: 20px; }
        .top h1 { margin: 0; font-size: 20px; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        td, th { padding: 8px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .grand { font-size: 15px; font-weight: bold; color: #b45309; text-align: right; margin-top: 18px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="top">
            <h1>HOTEL CALIFORNIA</h1>
            <p style="margin:4px 0 0; color:#64748b;">Bukti Reservasi & Invoice Resmi &bull; Kode: <strong>{{ $booking->booking_code }}</strong></p>
        </div>

        <p><strong>Nama Tamu:</strong> {{ $booking->user->name }} ({{ $booking->user->email }})</p>
        <p><strong>Status Reservasi:</strong> {{ strtoupper($booking->status) }}</p>

        <table>
            <thead>
                <tr style="background:#f8fafc;">
                    <th>Kamar</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Durasi</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->room->roomType->name }} (Kamar #{{ $booking->room->room_number }})</td>
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                    <td>{{ $booking->total_nights }} Malam</td>
                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="grand">
            Total Pembayaran: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
        </div>
    </div>
</body>
</html>