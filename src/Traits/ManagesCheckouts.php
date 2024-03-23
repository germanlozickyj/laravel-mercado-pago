<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Traits;

use LaravelMercadoPago\LaravelMercadoPago\Checkout;

trait ManagesCheckouts
{
    public function checkout(int $product_id, string $title, array $options = [], int $amount = 1)
    {
        return Checkout::make($product_id)
                ->withProductId($product_id)
                ->withDescription($options['description'])
                ->withCategoryId($options['category_id'])
                ->withPictureUrl($options['picture_url'])
                ->withQuantity($options['quantity'])
                ->withTitle($title)
                ->withAmount($amount);
    }
}
