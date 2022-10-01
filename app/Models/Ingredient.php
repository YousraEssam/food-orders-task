<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'merchant_id', 'main_stock', 'remaining_stock', 'is_stock_email_sent'];

    public $timestamps = true;

    /**
     * The products that belong to the ingredient.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ingredient_product')->withTimestamps();
    }

    /**
     * Get the merchant that owns the ingredient.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
