<?php

namespace Database\Factories;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AvailabilityFactory extends Factory
{
    protected $model = Availability::class;

    public function definition(): array
    {
        return [
            'starts_at' => Carbon::now()->addDays($this->faker->numberBetween( 1, 20 ))->format('Y-m-d H:i:s'),
            'ends_at' => Carbon::now()->addDays($this->faker->numberBetween( 1, 20 ))->format('Y-m-d H:i:s'),
            'user_id' => User::factory(),
        ];
    }
}
