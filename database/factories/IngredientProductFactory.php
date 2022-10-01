<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientProduct>
 */
class IngredientProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ingredient_id' => 1,
            'product_id' => 1,
            'quantity' => 0.15, // 150 gm -> 0.15 kg
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
