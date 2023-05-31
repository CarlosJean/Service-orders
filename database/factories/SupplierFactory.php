<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identType' => fake()->name(),
            'ident' => fake()->numerify('###########'),
            'name' => fake()->company(),
            'address' => fake()->address(),
            'cellphone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'city' => fake()->city(),
            'website' => fake()->url(),
        ];
    }
}
