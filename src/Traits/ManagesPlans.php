<?php

namespace App\Http\Traits;

use LaravelMercadoPago\LaravelMercadoPago\PlansMercadoPago;

trait ManagesPlans
{
    private PlansMercadoPago $planMercadoPago;

    public static function makePlan(
        string $back_url,
        string $reason
    ): self {
        $plan = new static();
        $plan->planMercadoPago = PlansMercadoPago::make()
            ->withBackUrl($back_url)
            ->withReason($reason);

        return $plan;
    }

    public function createMonthlyPlan(): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withAutoRecurring(1, 'months')
        );

        return $this;
    }

    public function createYearlyPlan(): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withAutoRecurring(12, 'months')
        );

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        if (! in_array($currency,
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
            //exception
        }

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

    private function setObjectMercadoPago(PlansMercadoPago $object): void
    {
        $this->planMercadoPago = $object;
    }

    public function repeatSubscriptionCycle(int $number): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withRepetitions($number)
        );

        return $this;
    }

    public function billingAtDay(int $day): self
    {
        if ($day < 1 || $day > 28) {
            //exception
        }

        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withBillingDay($day)
        );

        return $this;
    }

    public function billingDayProportional(bool $option): self
    {
        $this->setObjectMercadoPago(
            $this->planMercadoPago
                ->withBillingDayProportional($option)
        );

        return $this;
    }
}
