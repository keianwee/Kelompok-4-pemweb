<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RoomApiController extends Controller
{
    /**
     * GET /api/rooms/availability
     * Menampilkan ketersediaan unit kamar real-time per tipe kamar
     */
    public function availability(): JsonResponse
    {
        $roomTypes = RoomType::withCount([
            'rooms as total_rooms',
            'rooms as available_rooms' => function ($query) {
                $query->where('status', 'available');
            },
            'rooms as occupied_rooms' => function ($query) {
                $query->where('status', 'occupied');
            },
            'rooms as maintenance_rooms' => function ($query) {
                $query->where('status', 'maintenance');
            },
        ])->get()->map(function ($type) {
            return [
                'id' => $type->id,
                'room_type' => $type->name,
                'price_per_night' => (float) $type->price_per_night,
                'capacity' => $type->capacity,
                'total_rooms' => $type->total_rooms,
                'available_rooms' => $type->available_rooms,
                'occupied_rooms' => $type->occupied_rooms,
                'maintenance_rooms' => $type->maintenance_rooms,
                'is_bookable' => $type->available_rooms > 0,
            ];
        });

        return response()->json([
            'status' => 'success',
            'hotel' => 'Hotel California',
            'timestamp' => now()->toDateTimeString(),
            'data' => $roomTypes,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * GET /api/rooms/popular
     * Menampilkan daftar tipe kamar terpopuler berdasarkan jumlah transaksi reservasi
     */
    public function popular(): JsonResponse
    {
        $popularRooms = RoomType::select(
                'room_types.id',
                'room_types.name',
                'room_types.price_per_night',
                'room_types.capacity',
                DB::raw('COUNT(bookings.id) as total_bookings'),
                DB::raw('COALESCE(SUM(bookings.total_price), 0) as total_revenue')
            )
            ->leftJoin('rooms', 'room_types.id', '=', 'rooms.room_type_id')
            ->leftJoin('bookings', function ($join) {
                $join->on('rooms.id', '=', 'bookings.room_id')
                     ->where('bookings.status', '!=', 'cancelled');
            })
            ->groupBy('room_types.id', 'room_types.name', 'room_types.price_per_night', 'room_types.capacity')
            ->orderByDesc('total_bookings')
            ->get();

        return response()->json([
            'status' => 'success',
            'hotel' => 'Hotel California',
            'timestamp' => now()->toDateTimeString(),
            'data' => $popularRooms,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}