<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Mail\IngredientStockEmail;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\IngredientService;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\IngredientRepository;
use Illuminate\Support\Facades\Mail;

class OrderTest extends TestCase
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var User
     */
    public $user;

    /**
     * @var array
     */
    public $orderData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
        $ingredientRepo = new IngredientRepository();
        $productRepo = new ProductRepository();
        $orderRepo = new OrderRepository();
        $ingredientService = new IngredientService($ingredientRepo, $productRepo);
        $this->orderService = new OrderService($orderRepo, $productRepo, $ingredientService);
        $this->product = Product::find(1);
        $this->user = User::find(1);
    }

    public function test_order_is_created_successfully()
    {
        $products = [
            [
                "product_id" => $this->product->id,
                "quantity" => static::PRODUCT_QUANTITY
            ]
        ];
        $orderData = [
            "user_id" => $this->user->id,
            "total" => static::ORDER_TOTAL_PRICE,
        ];

        $this->assertInstanceOf(Order::class, $this->orderService->createNewOrder($products, $orderData));
    }

    public function test_order_is_created_successfully_and_no_mail_sent()
    {
        $products = [
            [
                "product_id" => $this->product->id,
                "quantity" => static::PRODUCT_QUANTITY
            ]
        ];
        $orderData = [
            "user_id" => $this->user->id,
            "total" => static::ORDER_TOTAL_PRICE,
        ];

        $this->assertInstanceOf(Order::class, $this->orderService->createNewOrder($products, $orderData));
        Mail::fake();
        Mail::assertNotSent(IngredientStockEmail::class);
    }
}
