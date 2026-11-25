<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $roomTypeId;
    protected $month;

    public function __construct($roomTypeId = null, $month = null)
    {
        $this->roomTypeId = $roomTypeId;
        $this->month = $month;
    }

    public function collection(): Enumerable
    {
        $query = Booking::with(['user', 'room.roomType'])->latest();

        if ($this->roomTypeId) {
            $query->whereHas('room', fn($q) => $q->where('room_type_id', $this->roomTypeId));
        }

        if ($this->month) {
            $query->where('check_in', 'like', $this->month . '%');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Kode Booking', 'Nama Tamu', 'Email Tamu', 'Tipe Kamar',
            'No. Kamar', 'Check-In', 'Check-Out', 'Malam', 'Total Harga (Rp)', 'Status'
        ];
    }

    public function map($b): array
    {
        return [
            $b->booking_code,
            $b->user->name,
            $b->user->email,
            $b->room->roomType->name,
            $b->room->room_number,
            $b->check_in,
            $b->check_out,
            $b->total_nights,
            $b->total_price,
            strtoupper($b->status),
        ];
    }
}