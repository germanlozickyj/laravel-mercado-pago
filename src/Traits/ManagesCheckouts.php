<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Traits;

use LaravelMercadoPago\LaravelMercadoPago\CheckoutLink;
use LaravelMercadoPago\LaravelMercadoPago\checkoutSubscription;

trait ManagesCheckouts
{
    public function checkoutLink(
        int $product_id, 
        string $title, 
        int $quantity,
        int $unit_price, 
        array $options = []
    ) : CheckoutLink
    {
        return CheckoutLink::make()
            ->withProductId($product_id)
            ->withTitle($title)
            ->withUnitPrice($unit_price)
            ->withQuantity($quantity)
            ->withDescription($options['description'])
            ->withCategoryId($options['category_id'])
            ->withPictureUrl($options['picture_url']);
    }

    public function checkoutSubscription(
        string $back_url, 
        string $card_token_id, 
        string $payer_email, 
        string $frequency_type, 
        int $frequency
    )
    {
        if(in_array($frequency_type, ['days', 'months'])) {
            //exception
        }

        return checkoutSubscription::make()
                            ->withBackUrl($back_url)
                            ->withCardTokenId($card_token_id)
                            ->withPayerEmail($payer_email)
    }

}
