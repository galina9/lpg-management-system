<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockHistory;

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

    public function decreaseStock(
        Product $product,
        float $quantity,
        string $note = 'Order stock out'
    ): void {
        $before = $product->stock;

        $product->decrement('stock', $quantity);

        $product->refresh();

        StockHistory::create([
            'product_id'   => $product->id,
            'user_id'      => auth()->id(),
            'type'         => 'OUT',
            'quantity'     => $quantity,
            'stock_before' => $before,
            'stock_after'  => $product->stock,
            'note'         => $note,
        ]);
    }

    public function increaseStock(
        Product $product,
        float $quantity,
        string $note = 'Stock returned'
    ): void {
        $before = $product->stock;

        $product->increment('stock', $quantity);

        $product->refresh();

        StockHistory::create([
            'product_id'   => $product->id,
            'user_id'      => auth()->id(),
            'type'         => 'IN',
            'quantity'     => $quantity,
            'stock_before' => $before,
            'stock_after'  => $product->stock,
            'note'         => $note,
        ]);
    }
}