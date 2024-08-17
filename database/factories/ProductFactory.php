<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate image
        $image = fake()->image('public/storage/products', 640, 480, null, false);
        // Generate fake name
        $name = fake()->colorName() . ' ' . fake()->randomElement(['T-Shirt', 'Shirt', 'Pants', 'Shoes', 'Hat']);

        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->randomNumber(6),
            'quantity' => fake()->randomNumber(2),
            'category_id' => fake()->randomElement([1, 2, 3]),
            'image' => 'products/' . $image,
        ];
    }
}
