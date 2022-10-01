<?php

namespace App\Http\Controllers\Api;

use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use Throwable;

class OrderController extends Controller
{
    /**
     * @var OrderService $ingredientService
     */
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Store new order.
     *
     * @param CreateOrderRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $order = $this->orderService->createNewOrder($request->get('products'), $request->only(['user_id', 'total']));

            DB::commit();

            return response()->json([
                'message' => "Order added successfully!",
                'order' => $order
            ], 201);

        } catch (Throwable $e) {

            DB::rollBack();

            return response()->json([
                'message' => "Order cannot be created!",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
