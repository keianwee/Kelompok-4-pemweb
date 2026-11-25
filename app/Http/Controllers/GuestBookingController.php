<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuestBookingController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount(['rooms as available_rooms_count' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        return view('guest.home', compact('roomTypes'));
    }

    public function showRoom(RoomType $roomType)
    {
        $availableRooms = $roomType->rooms()->where('status', 'available')->get();
        return view('guest.room_detail', compact('roomType', 'availableRooms'));
    }

    public function storeBooking(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'notes' => 'nullable|string|max:500',
        ]);

        $roomType = RoomType::findOrFail($data['room_type_id']);
        $room = $roomType->rooms()->where('status', 'available')->first();

        if (!$room) {
            return back()->with('error', 'Maaf, seluruh unit untuk tipe kamar ini baru saja penuh.');
        }

        $checkIn = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $roomType->price_per_night;

        $booking = Booking::create([
            'booking_code' => 'HC-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'total_nights' => $nights,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
            'notes' => $data['notes'],
        ]);

        // Otomatis ubah status kamar menjadi terisi (occupied)
        $room->update(['status' => 'occupied']);

        return redirect()->route('guest.bookings')
            ->with('success', 'Reservasi berhasil! Kode Booking Anda: ' . $booking->booking_code);
    }

    public function myBookings()
    {
        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('guest.bookings', compact('bookings'));
    }

    public function downloadInvoice(Booking $booking)
    {
        if (Auth::user()->role !== 'admin' && $booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses invoice ini.');
        }

        $booking->load(['user', 'room.roomType']);

        $pdf = Pdf::loadView('pdf.invoice', compact('booking'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Invoice-' . $booking->booking_code . '.pdf');
    }
}