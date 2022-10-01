<?php

namespace App\Repositories;

use App\Models\Ingredient;

class IngredientRepository
{
    /**
     * @param Ingredient $ingredient
     * @param array $fields
     *
     * @return boolean
     */
    public function updateIngredient(Ingredient $ingredient, array $fields): bool
    {
        return $ingredient->update($fields);
    }

    /**
     * Get ingredient quantity for this product.
     *
     * @param Ingredient $ingredient
     * @param array $productDetails
     *
     * @return float
     */
    public function getIngredientQuantity(Ingredient $ingredient, array $productDetails): float
    {
        return optional($ingredient->pivot->where([
            'product_id' => $productDetails['product_id'],
            'ingredient_id' => $ingredient->id
        ])->first())->quantity;
    }
}
