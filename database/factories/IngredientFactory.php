<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'merchant_id' => 1,
            'main_stock' => 20.00, // in Kilograms
            'remaining_stock' => 20.00, // in Kilograms
            'is_stock_email_sent' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
