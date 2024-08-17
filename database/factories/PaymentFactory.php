<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::all()->random()->id,
            'amount' => fake()->randomNumber(4),
            'payment_method' => fake()->randomElement(['credit card', 'paypal', 'bank transfer']),
            'payment_date' => fake()->dateTime(),
            'status' => fake()->randomElement(['successfull', 'failed']),
        ];
    }
}
