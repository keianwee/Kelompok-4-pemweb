<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. 4 Akun Manajemen / Karyawan
        $admins = [
            ['name' => 'Budi Santoso', 'email' => 'budi.admin@hotel.com', 'phone' => '0811100001', 'position' => 'General Manager'],
            ['name' => 'Siti Aminah', 'email' => 'siti.admin@hotel.com', 'phone' => '0811100002', 'position' => 'Front Office Supervisor'],
            ['name' => 'Andi Pratama', 'email' => 'andi.admin@hotel.com', 'phone' => '0811100003', 'position' => 'Resepsionis Shift Pagi'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.admin@hotel.com', 'phone' => '0811100004', 'position' => 'Resepsionis Shift Malam'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'phone' => $admin['phone'],
                'role' => 'admin',
                'position' => $admin['position'],
                'password' => $password,
            ]);
        }

        // 2. 4 Akun Pengunjung / Tamu
        $guestsData = [
            ['name' => 'Raka Wijaya', 'email' => 'raka.tamu@gmail.com', 'phone' => '081234567801'],
            ['name' => 'Nadia Putri', 'email' => 'nadia.tamu@gmail.com', 'phone' => '081234567802'],
            ['name' => 'Dimas Anggara', 'email' => 'dimas.tamu@gmail.com', 'phone' => '081234567803'],
            ['name' => 'Clara Kusuma', 'email' => 'clara.tamu@gmail.com', 'phone' => '081234567804'],
        ];

        $guests = [];
        foreach ($guestsData as $g) {
            $guests[] = User::create([
                'name' => $g['name'],
                'email' => $g['email'],
                'phone' => $g['phone'],
                'role' => 'guest',
                'password' => $password,
            ]);
        }

        // 3. 4 Tipe Kamar Minimalis Modern Hotel California
        $typesData = [
            [
                'name' => 'Standard Room',
                'price_per_night' => 350000,
                'capacity' => 2,
                'facilities' => 'Queen Bed, AC, Wi-Fi Cepat, TV 32", Shower Air Hangat',
                'description' => '<p>Kamar berdesain <strong>minimalis modern</strong> dengan pencahayaan hangat, cocok untuk pelancong bisnis maupun pasangan.</p><ul><li>Kasur ukuran Queen dengan linen katun premium</li><li>Meja kerja ergonomis &amp; koneksi Wi-Fi berkecepatan tinggi</li><li>Kamar mandi dalam dengan <em>rain shower</em> air hangat</li></ul>',
                'rooms' => [
                    ['number' => '101', 'status' => 'available'],
                    ['number' => '102', 'status' => 'occupied'],
                    ['number' => '103', 'status' => 'available'],
                ]
            ],
            [
                'name' => 'Superior Room',
                'price_per_night' => 500000,
                'capacity' => 2,
                'facilities' => 'King Bed, AC, Wi-Fi, Smart TV 43", Coffee Maker, Balkon Pribadi',
                'description' => '<p>Nikmati ruang istirahat lebih luas lengkap dengan <strong>balkon pribadi</strong> yang menghadap taman kota Hotel California.</p><ul><li>Kasur King Size dengan bantal ortopedi</li><li>Smart TV 43 inci (Netflix &amp; YouTube siap pakai)</li><li>Fasilitas pembuat kopi dan teh gratis setiap hari</li></ul>',
                'rooms' => [
                    ['number' => '201', 'status' => 'available'],
                    ['number' => '202', 'status' => 'occupied'],
                    ['number' => '203', 'status' => 'maintenance'],
                ]
            ],
            [
                'name' => 'Deluxe Pool View',
                'price_per_night' => 750000,
                'capacity' => 3,
                'facilities' => 'King Bed + Sofa, View Kolam Renang, Sarapan 2 Orang, Bathtub',
                'description' => '<p>Kamar elegan dengan jendela kaca penuh menghadap langsung ke <strong>kolam renang utama Hotel California</strong>.</p><ul><li>Termasuk sarapan prasmanan untuk 2 orang</li><li>Kamar mandi marmer mewah dilengkapi <em>bathtub</em></li><li>Area duduk santai dengan sofa minimalis</li></ul>',
                'rooms' => [
                    ['number' => '301', 'status' => 'available'],
                    ['number' => '302', 'status' => 'occupied'],
                    ['number' => '303', 'status' => 'available'],
                ]
            ],
            [
                'name' => 'Executive Suite',
                'price_per_night' => 1250000,
                'capacity' => 4,
                'facilities' => '2 Kamar Tidur, Ruang Tamu Pribadi, Sarapan 4 Orang, Mini Bar',
                'description' => '<p>Pengalaman menginap eksklusif terbaik di <strong>Hotel California</strong> dengan ruang tamu terpisah dan layanan prioritas.</p><ul><li>2 kamar tidur terpisah dengan pemandangan panorama kota</li><li>Akses gratis ke Executive Lounge &amp; Mini Bar</li><li>Termasuk sarapan untuk 4 orang tamu</li></ul>',
                'rooms' => [
                    ['number' => '401', 'status' => 'available'],
                    ['number' => '402', 'status' => 'available'],
                    ['number' => '403', 'status' => 'occupied'],
                ]
            ],
        ];

        $allRooms = [];
        foreach ($typesData as $t) {
            $roomType = RoomType::create([
                'name' => $t['name'],
                'price_per_night' => $t['price_per_night'],
                'capacity' => $t['capacity'],
                'facilities' => $t['facilities'],
                'description' => $t['description'],
            ]);

            foreach ($t['rooms'] as $r) {
                $allRooms[$r['number']] = Room::create([
                    'room_type_id' => $roomType->id,
                    'room_number' => $r['number'],
                    'status' => $r['status'],
                ]);
            }
        }

        // 4. 10 Data Transaksi / Booking
        $now = Carbon::now();
        $bookings = [
            ['code' => 'HC-20260901', 'guest' => 0, 'room' => '301', 'in' => $now->copy()->subMonths(2)->startOfMonth()->addDays(2), 'nights' => 2, 'status' => 'checked_out'],
            ['code' => 'HC-20260902', 'guest' => 1, 'room' => '401', 'in' => $now->copy()->subMonths(2)->startOfMonth()->addDays(10), 'nights' => 3, 'status' => 'checked_out'],
            ['code' => 'HC-20260903', 'guest' => 2, 'room' => '303', 'in' => $now->copy()->subMonths(2)->startOfMonth()->addDays(18), 'nights' => 2, 'status' => 'checked_out'],
            ['code' => 'HC-20261001', 'guest' => 3, 'room' => '201', 'in' => $now->copy()->subMonth()->startOfMonth()->addDays(4), 'nights' => 2, 'status' => 'checked_out'],
            ['code' => 'HC-20261002', 'guest' => 0, 'room' => '301', 'in' => $now->copy()->subMonth()->startOfMonth()->addDays(12), 'nights' => 3, 'status' => 'checked_out'],
            ['code' => 'HC-20261003', 'guest' => 1, 'room' => '101', 'in' => $now->copy()->subMonth()->startOfMonth()->addDays(20), 'nights' => 1, 'status' => 'checked_out'],
            ['code' => 'HC-20261101', 'guest' => 0, 'room' => '102', 'in' => $now->copy()->subDays(1), 'nights' => 3, 'status' => 'checked_in'],
            ['code' => 'HC-20261102', 'guest' => 1, 'room' => '202', 'in' => $now->copy()->subDays(2), 'nights' => 4, 'status' => 'checked_in'],
            ['code' => 'HC-20261103', 'guest' => 2, 'room' => '302', 'in' => $now->copy(), 'nights' => 2, 'status' => 'checked_in'],
            ['code' => 'HC-20261104', 'guest' => 3, 'room' => '403', 'in' => $now->copy(), 'nights' => 2, 'status' => 'checked_in'],
        ];

        foreach ($bookings as $b) {
            $room = $allRooms[$b['room']];
            $price = $room->roomType->price_per_night * $b['nights'];
            $checkIn = $b['in'];
            $checkOut = $checkIn->copy()->addDays($b['nights']);

            Booking::create([
                'booking_code' => $b['code'],
                'user_id' => $guests[$b['guest']]->id,
                'room_id' => $room->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'total_nights' => $b['nights'],
                'total_price' => $price,
                'status' => $b['status'],
                'notes' => 'Permintaan kamar lantai bebas asap rokok.',
                'created_at' => $checkIn,
                'updated_at' => $checkIn,
            ]);
        }
    }
}