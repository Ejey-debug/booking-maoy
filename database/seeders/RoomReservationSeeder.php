<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class RoomReservationSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Reservation::truncate();
        Room::truncate();
        Schema::enableForeignKeyConstraints();

        Storage::disk('public')->makeDirectory('rooms');

        $roomDescriptions = [
            'Cozy beachfront cabana with direct access to the shore and a private veranda.',
            'Spacious family suite featuring two queen beds and a panoramic sea view.',
            'Modern deluxe room equipped with smart TV, mini bar, and a luxurious bath.',
            'Rustic-inspired villa perfect for couples seeking a romantic getaway.',
            'Garden view room surrounded by lush greenery and tropical blooms.',
            'Penthouse suite offering the best sunset views and premium amenities.',
            'Poolside room with quick access to the infinity pool and lounge deck.',
            'Executive suite ideal for business travelers with dedicated workspace.',
            'Bamboo-inspired native hut with authentic local craftsmanship.',
            'Family loft with spacious living area and kitchenette for extended stays.',
        ];

        $baseImages = ['bg1.jpg', 'bg2.jpg', 'bg3.jpg'];

        $rooms = collect();

        foreach (range(1, 10) as $index) {
            $sourceImage = $baseImages[($index - 1) % count($baseImages)];
            $filename = sprintf('room-%02d.jpg', $index);
            $storagePath = "rooms/{$filename}";
            $publicImagePath = public_path("images/{$sourceImage}");

            if (file_exists($publicImagePath) && ! Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->put($storagePath, file_get_contents($publicImagePath));
            }

            $rooms->push(Room::create([
                'name' => 'Room ' . $index,
                'description' => $roomDescriptions[$index - 1],
                'price' => 3500 + ($index * 250),
                'image' => $storagePath,
            ]));
        }

        $reservationTemplates = [
            [3, '2025-10-05', '2025-10-08', 'active'],
            [5, '2025-10-12', '2025-10-15', 'active'],
            [2, '2025-10-01', '2025-10-03', 'completed'],
            [7, '2025-10-20', '2025-10-25', 'cancelled'],
            [1, '2025-10-18', '2025-10-20', 'active'],
        ];

        foreach ($reservationTemplates as $index => [$roomOffset, $checkIn, $checkOut, $status]) {
            $room = $rooms[$roomOffset - 1];

            $reservation = new Reservation();
            $reservation->room_id = $room->id;
            $reservation->name = ['Juan Dela Cruz', 'Maria Santos', 'Pedro Reyes', 'Ana Villanueva', 'Liza Morales'][$index];
            $reservation->email = ['juan@example.com', 'maria@example.com', 'pedro@example.com', 'ana@example.com', 'liza@example.com'][$index];
            $reservation->contact = ['09171234567', '09179876543', '09201239876', '09351234567', '09181231234'][$index];
            $reservation->check_in_date = Carbon::parse($checkIn);
            $reservation->check_out_date = Carbon::parse($checkOut);
            $reservation->guests = [2, 4, 2, 2, 3][$index];
            $reservation->status = $status;
            $nights = max(Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)), 1);
            $reservation->total_price = $room->price * $nights;
            $reservation->is_seen = false;
            $reservation->payment_alert = false;
            $reservation->save();
        }
    }
}
