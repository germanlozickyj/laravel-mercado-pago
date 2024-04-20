<?php

namespace App\Http\Traits;

use App\Http\PlansMercadoPago;

trait ManagesPlans
{
    private PlansMercadoPago $planMercadoPago;

    public static function makePlan(
        string $back_url, 
        string $reason
    ) : self 
    {
        $plan = new static();
        $plan->planMercadoPago = PlansMercadoPago::make()
                                    ->withBackUrl($back_url)
                                    ->withReason($reason);

        return $plan;
    }

    private function createPlan(
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

    public function createMonthlyPlan() : self
    {   
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withAutoRecurring(1, 'months')
        );

        return $this;
    }

    public function createYearlyPlan() : self
    {   
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withAutoRecurring(12, 'months')
        );

        return $this;
    }

    public function setCurrency(string $currency): self 
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withCurrency($currency)
        );

        return $this;
    }

    public function hasMonthlyFreeTrial(int $months): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withFreeTrial($months, 'months')
        );

        return $this;
    }

    public function hasDailyFreeTrial(int $days): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withFreeTrial($days, 'days')
        );

        return $this;
    }

    private function setObjectMercadoPago(PlansMercadoPago $object) : void
    {
        $this->planMercadoPago = $object;
    }


}
