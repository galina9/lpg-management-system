<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockHistory;
use App\Services\StockService;

class StockService
{
    public static function out(Product $product, float $quantity, ?string $note = null): void
    {
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

    public static function in(Product $product, float $quantity, ?string $note = null): void
    {
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