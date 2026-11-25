<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        \App\Http\Controllers\Admin\BackupController::autoBackupDaily();
        // Ringkasan Kartu Atas
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $totalRevenue = Booking::where('status', '!=', 'cancelled')->sum('total_price');

        // Data Grafik 1: Pendapatan per Bulan (6 bulan terakhir)
        $monthlySales = Booking::select(
                DB::raw("DATE_FORMAT(check_in, '%Y-%m') as month"),
                DB::raw("SUM(total_price) as revenue")
            )
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->limit(6)
            ->get();

        $chartMonths = $monthlySales->pluck('month');
        $chartRevenues = $monthlySales->pluck('revenue');

        // Data Grafik 2: Tren Tipe Kamar Paling Laris
        $popularTypes = RoomType::withCount(['rooms as total_bookings' => function ($query) {
            $query->join('bookings', 'rooms.id', '=', 'bookings.room_id')
                  ->where('bookings.status', '!=', 'cancelled');
        }])->get();

        $typeLabels = $popularTypes->pluck('name');
        $typeCounts = $popularTypes->pluck('total_bookings');

        return view('admin.dashboard', compact(
            'totalRooms', 'availableRooms', 'occupiedRooms', 'totalRevenue',
            'chartMonths', 'chartRevenues', 'typeLabels', 'typeCounts'
        ));
    }
}