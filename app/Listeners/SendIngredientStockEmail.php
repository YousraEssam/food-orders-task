<?php

namespace App\Listeners;

use App\Events\IngredientStockUpdate;
use App\Mail\IngredientStockEmail;
use App\Models\Ingredient;
use App\Services\IngredientService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendIngredientStockEmail
{
    protected $ingredientService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }


    /**
     * Handle the event.
     *
     * @param  IngredientStockUpdate  $event
     * @return void
     */
    public function handle(IngredientStockUpdate $event): void
    {
        $ingredient = $event->ingredient;

        $isHalfStockReached = $this->ingredientService->checkIfHalfStockRemaining($ingredient->remaining_stock, $ingredient->main_stock);

        if ($isHalfStockReached && !$ingredient->is_stock_email_sent ) {
            $this->sendStockMail($ingredient);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  IngredientStockUpdate  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(IngredientStockUpdate $event, Throwable $exception): void
    {
        Log::error('Event '. get_class($event) .'due to exception: '. $exception->getMessage());
    }

    /**
     * Send stock mail.
     *
     * @param Ingredient $ingredient
     *
     * @return void
     */
    private function sendStockMail(Ingredient $ingredient): void
    {
        $mailData = [
            'title' => 'Ingredient Stock Alert',
            'body' => 'Please our organization needs to buy more stock from this ingredient: '. $ingredient->name
        ];

        dd($ingredient->merchant->email);
        $mailMessage = Mail::to($ingredient->merchant->email)->send(new IngredientStockEmail($mailData));

        if($mailMessage instanceof SentMessage) {
            Log::info('Mail is sent succesfully for ingredient: '. $ingredient->name);
            $ingredient->update(['is_stock_email_sent' => true]);
        }
    }
}
