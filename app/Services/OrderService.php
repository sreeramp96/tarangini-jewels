<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Collection;

class OrderService
{
    const TAX_RATE = 0.18;
    const SHIPPING_COST = 100.00;

    public function calculateTotals(Collection $cartItems)
    {
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $shipping = ($subtotal > 500 || $subtotal == 0) ? 0 : self::SHIPPING_COST;

        $tax = $subtotal * self::TAX_RATE;
        $grandTotal = $subtotal + $tax + $shipping;

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'tax_rate' => self::TAX_RATE
        ];
    }
}
