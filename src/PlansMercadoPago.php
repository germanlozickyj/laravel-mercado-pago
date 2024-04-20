<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Support\Facades\Http;
use LaravelMercadoPago\LaravelMercadoPago\Contracs\ManagesApiResponses;

class PlansMercadoPago implements ManagesApiResponses
{
    private string $back_url;

    private string $reason;

    private array $auto_recurring;

    private array $payment_methods_allowed;

    private array $custom_auto_recurring;

    public static function make(): static
    {
        return new static();
    }

    public function withBackUrl(string $back_url): self
    {
        $this->back_url = $back_url;

        return $this;
    }

    public function withReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function withAutoRecurring(int $frequency, string $frequency_type): self
    {
        $this->auto_recurring['frequency_type'] = $frequency_type;
        $this->auto_recurring['frequency'] = $frequency;

        return $this;
    }

    public function withRepetitions(int $number): self
    {
        $this->auto_recurring['repetitions'] = $number;

        return $this;
    }

    public function withCurrency(string $currency) : self
    {
        $this->auto_recurring['currency_id'] = $currency;
        
        return $this;
    }

    public function withBillingDay(int $day) : self
    {
        $this->auto_recurring['billing_day'] = $day;
        
        return $this;
    }

    public function withBillingDayProportional(bool $option) : self
    {
        $this->auto_recurring['billing_day_proportional'] = $option;
        
        return $this;
    }

    public function withFreeTrial(int $frequency, string $frequency_type) : self
    {
        $this->auto_recurring['free_trial'] = [
            'frequency' => $frequency,
            'frequency_type' => $frequency_type
        ];

        return $this;
    }

    public function create()
    {
        $response = LaravelMercadoPago::api('POST', 'preapproval_plan', [
            'auto_recurring' => $this->auto_recurring,
            'back_url' => $this->back_url,
            'payment_methods_allowed' => array_merge(
                $this->payment_methods_allowed,
                $this->custom_auto_recurring
            ),
            'reason' => $this->reason,
        ]);

        //TODO save in db
    }


    public function handleStatusCode(Http $response)
    {
    }

    public function handleExpection(Http $response)
    {
    }

    public function handleResponse(Http $response)
    {
    }

    public function resolve(Http $response)
    {
    }
}
