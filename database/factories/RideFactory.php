<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_location' => fake()->text(10),
            'end_location' => fake()->text(10),
            'date' => date("Y-m-d H:i:s"),
            'space' => rand(1, 7),
            'user_id' => User::factory()
        ];
    }
}
