<?php

namespace App\Services;

use Mockery\Exception;
use App\Models\Product;
use App\Models\Ingredient;
use App\Events\IngredientStockUpdate;
use App\Repositories\ProductRepository;
use App\Repositories\IngredientRepository;

class IngredientService
{
    /**
     * @var IngredientRepository $ingredientRepo
     */
    protected $ingredientRepo;

    /**
     * @var ProductRepository $productRepo
     */
    protected $productRepo;

    public function __construct(IngredientRepository $ingredientRepo, ProductRepository $productRepo)
    {
        $this->ingredientRepo = $ingredientRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * @param Product $product
     * @param array $productDetails
     *
     * @throws Exception
     * @return bool
     */
    public function calculateStock(Product $product, array $productDetails): bool
    {
        $productIngredients = $product->ingredients()->get();
        $isUpdated = false;

        foreach($productIngredients as $ingredient) {
            $remainingStock = $this->calculateRemainingStock($ingredient, $productDetails);

            $isUpdated = $this->updateIngredient($ingredient, ['remaining_stock' => $remainingStock]);

            if(!$isUpdated || $remainingStock <= 0.00) {
                throw new Exception("Please check stock availability", 500);
            }

            IngredientStockUpdate::dispatch($ingredient);
        }

        return $isUpdated;
    }

    /**
     * Calculate ingredient remainiing stock.
     *
     * @param Ingredient $ingredient
     * @param array $productDetails
     *
     * @return float
     */
    private function calculateRemainingStock(Ingredient $ingredient, array $productDetails): float
    {
        $ingredientQuantity = $this->ingredientRepo->getIngredientQuantity($ingredient, $productDetails);
        $neededStock = $productDetails['quantity'] * $ingredientQuantity;
        return ( $ingredient->remaining_stock ) - $neededStock;
    }

    /**
     * Update ingredient record with specific fields.
     *
     * @param Ingredient $ingredient
     * @param array $fields
     *
     * @return bool
     */
    private function updateIngredient(Ingredient $ingredient, array $fields): bool
    {
        return $this->ingredientRepo->updateIngredient($ingredient, $fields);
    }

    /**
     * Check if ingredient stock is less than 50%
     *
     * @param float $remainingStock
     * @param float $availableStock
     *
     * @return bool
     */
    public function checkIfHalfStockRemaining(float $remainingStock, float $availableStock): bool
    {
        return ( ($remainingStock/$availableStock) * 100 ) <= 50;
    }

}
