<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RoomType;
use App\Exports\BookingsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingManagementController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room.roomType'])->latest()->get();
        $roomTypes = RoomType::all();
        return view('admin.bookings.index', compact('bookings', 'roomTypes'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled']);
        $booking->update(['status' => $request->status]);

        if ($request->status === 'checked_in') {
            $booking->room->update(['status' => 'occupied']);
        } elseif (in_array($request->status, ['checked_out', 'cancelled'])) {
            $booking->room->update(['status' => 'available']);
        }

        return back()->with('success', 'Status reservasi diperbarui.');
    }

    public function exportExcel(Request $request)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "Laporan-Reservasi-HotelCalifornia_{$timestamp}.xlsx";
        return Excel::download(new BookingsExport($request->room_type_id, $request->month), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = Booking::with(['user', 'room.roomType'])->latest();

        if ($request->room_type_id) {
            $query->whereHas('room', fn($q) => $q->where('room_type_id', $request->room_type_id));
        }
        if ($request->month) {
            $query->where('check_in', 'like', $request->month . '%');
        }

        $bookings = $query->get();
        $totalRevenue = $bookings->where('status', '!=', 'cancelled')->sum('total_price');
        $timestamp = now()->format('Y-m-d_H-i-s');

        $pdf = Pdf::loadView('pdf.bookings-report', compact('bookings', 'totalRevenue'));
        return $pdf->download("Laporan-Keuangan-HotelCalifornia_{$timestamp}.pdf");
    }
}