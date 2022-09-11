<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reservation;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            'Kraljevo',
            'Beograd',
            'Nis',
            'Kragujevac',
            'Cacak',
            'Krusevac',
            'Novi Sad',
            'Smederevo',
            'Zajecar',
            'Zlatibor',
            'Uzice',
            'Tara'
        ];

        $user = User::factory()->create([
            'first_name' => 'Branimir',
            'last_name' => 'Cirovic',
            'email' => 'branimir@gmail.com',
            'password' => Hash::make('branimir'),
        ]);

        $users = User::factory()->count(10)->create();
        $rides = [];

        for ($i = 0; $i < 15; $i++) {
            $startLocation = $locations[rand(0, sizeof($locations) - 1)];
            $endLocation = $locations[rand(0, sizeof($locations) - 1)];

            while ($startLocation === $endLocation) {
                $endLocation = $locations[rand(0, sizeof($locations) - 1)];
            }

            $ride = Ride::factory()->create([
                'user_id' => $users[rand(0, sizeof($users) - 1)],
                'start_location' => $startLocation,
                'end_location' => $endLocation,
                'date' => date('Y:m:d H:i:s'),
                'space' => rand(1, 10),
            ]);

            array_push($rides, $ride);
        }

        Reservation::factory()->create([
            'user_id' => $users[rand(0, sizeof($users) - 1)],
            'ride_id' => $rides[rand(0, sizeof($rides) - 1)],
            'space' => 1
        ]);
    }
}
