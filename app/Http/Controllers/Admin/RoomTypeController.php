<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')->latest()->get();
        return view('admin.room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('room-types', 'public');
        }

        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function edit(RoomType $roomType)
    {
        return view('admin.room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name,' . $roomType->id,
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
                Storage::disk('public')->delete($roomType->image);
            }
            $validated['image'] = $request->file('image')->store('room-types', 'public');
        }

        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return back()->with('error', 'Tipe kamar tidak dapat dihapus karena masih memiliki unit kamar.');
        }

        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Tipe kamar berhasil dihapus.');
    }
}