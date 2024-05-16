<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Traits;

use LaravelMercadoPago\LaravelMercadoPago\CheckoutLink;
use LaravelMercadoPago\LaravelMercadoPago\checkoutSubscription;
use LaravelMercadoPago\LaravelMercadoPago\Exceptions\MercadoPagoParamException;

trait ManagesCheckouts
{
    public function checkoutLink(
        int $product_id,
        string $title,
        int $quantity,
        int $unit_price,
        array $options = []
    ): CheckoutLink {
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
        array $auto_recurring = [],
    ) {
        $this->ValidateAutoRecurring($auto_recurring);

        return checkoutSubscription::make()
            ->withBackUrl($back_url)
            ->withCardTokenId($card_token_id)
            ->withPayerEmail($payer_email);
    }

    public function ValidateAutoRecurring(array $auto_recurring)
    {
        if (empty($auto_recurring)) {
            return;
        }
        if (in_array(['frequency', 'frequency_type', 'currency_id'], $auto_recurring)) {
           throw new MercadoPagoParamException("frequency, frequency_type, 'currency_id are required in auto_recurring");
        }
        if (in_array($auto_recurring['frequency_type'], ['days', 'months'])) {
            throw new MercadoPagoParamException("frequency_type must be 'days' or 'months' not {$auto_recurring['frequency_type']}");
        }
        if (
            in_array($auto_recurring['currency_id'],
                [
                    'ARS',
                    'BRL',
                    'CLP',
                    'MXN',
                    'COP',
                    'PEN',
                    'UYU',
                ]
            )) {
            throw new MercadoPagoParamException("currency_id is incorrect currencies allowed: 'ARS','BRL','CLP','MXN','COP','PEN','UYU'");
        }
    }
}
