<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public static function generateBackupPayload(): string
    {
        return json_encode([
            'exported_at' => now()->toDateTimeString(),
            'users' => User::all()->makeVisible(['password'])->toArray(),
            'room_types' => RoomType::all()->toArray(),
            'rooms' => Room::all()->toArray(),
            'bookings' => Booking::all()->toArray(),
        ], JSON_PRETTY_PRINT);
    }

    // Dipanggil otomatis setiap hari saat admin membuka dashboard
    public static function autoBackupDaily(): void
    {
        $filename = 'backups/auto-backup-' . now()->format('Y-m-d') . '.json';
        if (!Storage::disk('local')->exists($filename)) {
            Storage::disk('local')->put($filename, self::generateBackupPayload());
        }
    }

    public function index()
    {
        self::autoBackupDaily();
        $files = collect(Storage::disk('local')->files('backups'))->sortDesc();
        return view('admin.backup.index', compact('files'));
    }

    public function downloadNow()
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return response(self::generateBackupPayload(), 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"Backup-HotelCalifornia_{$timestamp}.json\"",
        ]);
    }

    public function downloadStored($filename)
    {
        return Storage::disk('local')->download('backups/' . basename($filename));
    }

    public function import(Request $request)
    {
        $request->validate(['backup_file' => 'required|file']);
        $data = json_decode(file_get_contents($request->file('backup_file')->getRealPath()), true);

        if (!$data || !isset($data['room_types'], $data['rooms'], $data['bookings'])) {
            return back()->with('error', 'Format file backup tidak valid.');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Booking::truncate();
        Room::truncate();
        RoomType::truncate();

        foreach ($data['users'] ?? [] as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }
        foreach ($data['room_types'] as $rt) {
            RoomType::create($rt);
        }
        foreach ($data['rooms'] as $r) {
            Room::create($r);
        }
        foreach ($data['bookings'] as $b) {
            Booking::create($b);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return back()->with('success', 'Seluruh data database berhasil dipulihkan (Restore)!')->withInput([]);
    }
}