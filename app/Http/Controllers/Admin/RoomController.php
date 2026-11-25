<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        $roomTypes = RoomType::orderBy('name')->get();
        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:20|unique:rooms,room_number',
            'floor' => 'nullable|integer|min:1',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Unit kamar berhasil ditambahkan.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $room->id,
            'floor' => 'nullable|integer|min:1',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Unit kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->bookings()->whereIn('status', ['pending', 'confirmed', 'checked_in'])->exists()) {
            return back()->with('error', 'Kamar tidak dapat dihapus karena masih memiliki reservasi aktif.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Unit kamar berhasil dihapus.');
    }
}