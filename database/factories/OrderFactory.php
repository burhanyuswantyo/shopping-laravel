<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'total_amount' => fake()->randomNumber(5),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
            'shipping_address' => fake()->address(),
            'payment_status' => fake()->randomElement(['unpaid', 'paid', 'refunded']),
        ];
    }
}
