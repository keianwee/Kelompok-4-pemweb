<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function home()
    {
        $roomTypes = RoomType::withCount([
            'rooms as available_rooms_count' => function ($query) {
                $query->where('status', 'available');
            }
        ])->get();

        return view('guest.home', compact('roomTypes'));
    }

    public function myBookings()
    {
        $bookings = Booking::with(['room.roomType'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('guest.bookings.index', compact('bookings'));
    }

    public function bookings()
    {
        return $this->myBookings();
    }

    public function createBooking(Request $request)
    {
        $roomTypes = RoomType::withCount([
            'rooms as available_rooms_count' => function ($query) {
                $query->where('status', 'available');
            }
        ])->get();

        $selectedTypeId = $request->query('room_type_id');

        if ($selectedTypeId) {
            $selectedType = $roomTypes->firstWhere('id', $selectedTypeId);
            if ($selectedType && $selectedType->available_rooms_count < 1) {
                session()->flash('error', 'Maaf, seluruh unit untuk tipe kamar "' . $selectedType->name . '" saat ini sedang penuh (0 kamar tersedia). Silakan pilih tipe kamar lainnya.');
            }
        }

        return view('guest.bookings.create', compact('roomTypes', 'selectedTypeId'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in'     => 'required|date|after_or_equal:today',
            'check_out'    => 'required|date|after:check_in',
            'notes'        => 'nullable|string|max:500',
        ]);

        $availableRoom = Room::where('room_type_id', $validated['room_type_id'])
            ->where('status', 'available')
            ->first();

        if (!$availableRoom) {
            $roomType = RoomType::find($validated['room_type_id']);
            return back()
                ->withInput()
                ->with('error', 'Pemesanan gagal! Kamar tipe "' . ($roomType->name ?? 'pilihan Anda') . '" sudah penuh (sisa 0 kamar). Silakan pilih tipe kamar lain.');
        }

        $checkIn  = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights   = max(1, $checkIn->diffInDays($checkOut));

        $roomType   = RoomType::findOrFail($validated['room_type_id']);
        $totalPrice = $nights * $roomType->price_per_night;

        Booking::create([
            'booking_code' => 'HC-' . strtoupper(Str::random(6)),
            'user_id'      => auth()->id(),
            'room_id'      => $availableRoom->id,
            'check_in'     => $validated['check_in'],
            'check_out'    => $validated['check_out'],
            'total_nights' => $nights,
            'total_price'  => $totalPrice,
            'status'       => 'pending',
            'notes'        => $validated['notes'] ?? null,
        ]);

        $availableRoom->update(['status' => 'occupied']);

        return redirect()
            ->route('guest.bookings.index')
            ->with('success', 'Reservasi berhasil dibuat! Silakan unduh invoice PDF Anda.');
    }

    public function downloadInvoice(Booking $booking)
    {
        if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        $booking->load(['user', 'room.roomType']);

        $pdf = Pdf::loadView('pdf.invoice', compact('booking'));
        $filename = 'Invoice_' . $booking->booking_code . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}