<?php

namespace App\Services;

use App\Models\Order;
use App\Services\IngredientService;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService
{
    /**
     * @var OrderRepository $orderRepo
     */
    protected $orderRepo;

    /**
     * @var IngredientService $ingredientService
     */
    protected $ingredientService;

    /**
     * @var ProductRepository $productRepo
     */
    protected $productRepo;

    public function __construct(
        OrderRepository $orderRepo,
        ProductRepository $productRepo,
        IngredientService $ingredientService
    ) {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->ingredientService = $ingredientService;
    }

    /**
     * Create new order.
     *
     * @param array $products
     * @param array $orderData
     *
     * @return Order|null
     */
    public function createNewOrder(array $products, array $orderData): ?Order
    {
        $order = $this->orderRepo->createOrder($orderData);
        Log::info('Order will be created with id: '. $order->id);
        $isStockUpdated = false;

        foreach($products as $productDetails){
            $product = $this->productRepo->findOneById($productDetails['product_id']);
            $product->orders()->attach($order->id);

            $isStockUpdated = $this->ingredientService->calculateStock($product, $productDetails);
        }

        return ($isStockUpdated && $order) ? $order : null;
    }
}
