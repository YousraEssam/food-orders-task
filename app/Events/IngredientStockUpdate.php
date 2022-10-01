<?php

namespace App\Events;

use App\Models\Ingredient;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientStockUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var Ingredient
     */
    public $ingredient;

    /**
     * Create a new event instance.
     *
     * @param  Ingredient  $ingredient
     * @return void
     */
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }
}
