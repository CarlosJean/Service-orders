<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItemsDetail>
 */
class OrderItemsDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_item_id' => 1,
            'item_id' => fake()->numberBetween(1,5),
            'order_item_id' => 1,
            'quantity' => fake()->randomFloat(2, 1,10)
        ];
    }
}
