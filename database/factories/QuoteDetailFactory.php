<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteDetail>
 */
class QuoteDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quote_id' => 1,
            'item_id' => null,
            'supplier_id' => fake()->numberBetween(2,5),
            'item' => fake()->word(),
            'reference' => fake()->words(4,true),
            'quantity' => fake()->randomFloat(2,1,50),
            'price' => fake()->randomFloat(2,1,99999),
        ];
    }
}
