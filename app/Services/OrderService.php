<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;


class OrderService
{
    public function calculateTotal(Product $product, float $quantity): float
    {
        return $product->sale_price * $quantity;
    }

    public function hasEnoughStock(Product $product, float $quantity): bool
    {
        return $product->stock >= $quantity;
    }

    public function decreaseStock(Product $product, float $quantity): void
    {
        $product->decrement('stock', $quantity);
    }

    public function increaseStock(Product $product, float $quantity): void
    {
        $product->increment('stock', $quantity);
    }
}