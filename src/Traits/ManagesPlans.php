<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Traits;

use LaravelMercadoPago\LaravelMercadoPago\PlansMercadoPago;

trait ManagesPlans
{
    public function createPlan(
        string $back_url, 
        string $reason,
        string $frequency,
        string $frequency_type,
        array $payment_methods_allowed
    )
    {
        return PlansMercadoPago::make()
                        ->withBackUrl($back_url)
                        ->withReason($reason)
                        ->withAutoRecurring()
                        ->withPaymentMethodsAllowed()
                        ->create();
    }
}