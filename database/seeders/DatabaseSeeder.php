<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use App\Models\IngredientProduct;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('123456')
        ]);

        Product::factory()->create();

        Merchant::factory()->create();
        Merchant::factory()->create();

        Ingredient::factory()->create();
        Ingredient::factory()->create([
            'merchant_id' => 2,
            'main_stock' => 5.00,
            'remaining_stock' => 5.00,
        ]);
        Ingredient::factory()->create([
            'main_stock' => 1.00,
            'remaining_stock' => 1.00,
        ]);

        IngredientProduct::factory()->create();
        IngredientProduct::factory()->create([
            'ingredient_id' => 2,
            'quantity' => 0.03,
        ]);
        IngredientProduct::factory()->create([
            'ingredient_id' => 3,
            'quantity' => 0.02,
        ]);
    }
}
