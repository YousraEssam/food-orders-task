<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The ingredients that belong to the product.
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_product')->withTimestamps();
    }

    /**
     * The orders that belong to the product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withTimestamps();
    }
}
