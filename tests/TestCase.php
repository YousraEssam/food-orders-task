<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected const ORDER_TOTAL_PRICE = 120.00;
    protected const PRODUCT_QUANTITY = 20;

    protected function setUp(): void
    {
        parent::setUp();
    }
}
