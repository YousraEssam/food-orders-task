<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Merchant;
use App\Models\Ingredient;
use Tests\TestCase;
use App\Models\IngredientProduct;
use App\Services\IngredientService;
use App\Repositories\ProductRepository;
use App\Repositories\IngredientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientsTest extends TestCase
{
    /**
     * @var IngredientService
     */
    protected $ingredientService;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Merchant
     */
    public $merchant;

    /**
     * @var Ingredient
     */
    public $ingredient;

    /**
     * @var Ingredient
     */
    public $ingredientProduct;

    /**
     * @var array
     */
    public $productDetails;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');

        $this->ingredientService = new IngredientService(new IngredientRepository(), new ProductRepository());

        $this->product = Product::find(1);
        $this->productDetails = $this->getProductDetailsArray();
        $this->merchant = Merchant::find(1);
        $this->ingredient = Ingredient::find(3);
        $this->ingredientProduct = IngredientProduct::where([
            'ingredient_id' => $this->ingredient->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function test_that_stock_is_calculated_successfully()
    {
        $this->assertTrue($this->ingredientService->calculateStock($this->product, $this->productDetails));
    }

    /**
     * Get product details array sent in create order payload.
     *
     * @return array
     */
    private function getProductDetailsArray(): array
    {
        return [
            'product_id' => $this->product->id,
            'quantity' => static::PRODUCT_QUANTITY
        ];
    }
}
