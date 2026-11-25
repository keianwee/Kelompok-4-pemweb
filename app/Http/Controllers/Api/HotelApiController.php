<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;

class HotelApiController extends Controller
{
    // Endpoint 1: Daftar ketersediaan kamar (kosong vs terisi)
    public function availability()
    {
        $roomTypes = RoomType::with('rooms')->get()->map(function ($type) {
            return [
                'id' => $type->id,
                'room_type' => $type->name,
                'price_per_night' => $type->price_per_night,
                'capacity' => $type->capacity,
                'total_units' => $type->rooms->count(),
                'available_count' => $type->rooms->where('status', 'available')->count(),
                'occupied_count' => $type->rooms->where('status', 'occupied')->count(),
                'available_room_numbers' => $type->rooms->where('status', 'available')->pluck('room_number')->values(),
                'occupied_room_numbers' => $type->rooms->where('status', 'occupied')->pluck('room_number')->values(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'hotel' => 'Hotel California',
            'timestamp' => now()->toDateTimeString(),
            'summary' => [
                'total_rooms' => Room::count(),
                'total_available' => Room::where('status', 'available')->count(),
                'total_occupied' => Room::where('status', 'occupied')->count(),
            ],
            'data' => $roomTypes,
        ]);
    }

    // Endpoint 2: Tren tipe kamar paling laris
    public function popular()
    {
        $popular = RoomType::withCount(['rooms as total_bookings' => function ($query) {
            $query->join('bookings', 'rooms.id', '=', 'bookings.room_id')
                  ->where('bookings.status', '!=', 'cancelled');
        }])
        ->orderByDesc('total_bookings')
        ->get()
        ->map(function ($type, $index) {
            return [
                'rank' => $index + 1,
                'room_type' => $type->name,
                'price_per_night' => $type->price_per_night,
                'total_bookings' => $type->total_bookings,
            ];
        });

        return response()->json([
            'status' => 'success',
            'hotel' => 'Hotel California',
            'description' => 'Peringkat tipe kamar paling banyak dipesan',
            'data' => $popular,
        ]);
    }
}