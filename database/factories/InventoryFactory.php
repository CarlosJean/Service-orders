<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => fake()->numberBetween(1,6),
            'quantity' => fake()->randomFloat(2,1,10),
            'price' => fake()->randomFloat(2,100,1100),
        ];
    }
}
