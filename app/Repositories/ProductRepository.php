<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findOneById($productId)
    {
        return Product::with('ingredients')->find($productId);
    }
}
