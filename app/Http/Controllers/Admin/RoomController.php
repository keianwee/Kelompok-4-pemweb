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
        $roomTypes = RoomType::all();
        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Nomor kamar ' . $data['room_number'] . ' berhasil ditambahkan.');
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Status kamar ' . $room->room_number . ' berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Unit kamar berhasil dihapus.');
    }
}