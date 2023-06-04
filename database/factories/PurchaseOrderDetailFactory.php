<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrderDetail>
 */
class PurchaseOrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_order_id' => 1,
            'item_id' => fake()->numberBetween(2, 5),
            'supplier_id' => fake()->numberBetween(1, 5),
            'reference' => fake()->word(),
            'price' => fake()->randomFloat(2, 10, 3000),
            'quantity' => fake()->randomFloat(2, 10, 25),
            'total_price' => fake()->randomFloat(2, 10, 10000),
        ];
    }
}
