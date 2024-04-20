<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Traits;

use LaravelMercadoPago\LaravelMercadoPago\PlansMercadoPago;

trait ManagesPlans
{
    public function createPlan(
        string $back_url,
        string $reason,
        int $frequency,
        string $frequency_type,
        array $payment_methods_allowed = [],
        array $custom_auto_recurring = [],
    ) {
        $plan = PlansMercadoPago::make()
            ->withBackUrl($back_url)
            ->withReason($reason)
            ->withAutoRecurring($frequency, $frequency_type);

        if (! empty($payment_methods_allowed)) {
            $this->withPaymentMethodsAllowed($payment_methods_allowed);
        }
        if (! empty($custom_auto_recurring)) {
            $this->withCustomAutoRecurring($payment_methods_allowed);
        }

        $plan->create();
    }
}
