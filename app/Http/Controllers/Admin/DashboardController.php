<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRoomTypes = RoomType::count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::whereIn('status', ['confirmed', 'checked_in'])->count();
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'checked_in', 'checked_out'])->sum('total_price');
        $totalGuests = User::where('role', 'guest')->count();

        $recentBookings = Booking::with(['user', 'room.roomType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRoomTypes',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'totalRevenue',
            'totalGuests',
            'recentBookings'
        ));
    }
}