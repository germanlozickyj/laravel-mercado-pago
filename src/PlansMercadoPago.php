<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class PlansMercadoPago implements Responsable
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

    public function create()
    {
        $response = LaravelMercadoPago::api('POST', 'preapproval_plan', [
            'auto_recurring' => $this->auto_recurring,
            'back_url' => $this->back_url,
            'payment_methods_allowed' => $this->payment_methods_allowed,
            'reason' => $this->reason,
        ]);

        //TODO save in db
    }

    public function withCustomAutoRecurring(array $custom_auto_recurring_data) : self 
    {
        $this->custom_auto_recurring = [
            'repetitions' => $custom_auto_recurring_data['repetitions'] ?? '',
            'billing_day' => $custom_auto_recurring_data['billing_day'] ?? '',
            'billing_day_proportional' => $custom_auto_recurring_data['billing_day_proportional'] ?? '',
        ];

        return $this;
    }

    public function withPaymentMethodsAllowed(array $payment_methods_allowed) : self
    {
        $this->payment_methods_allowed = [
            'payment_types' => 
                isset($payment_methods_allowed['payment_types']) ? 
                $payment_methods_allowed['payment_types']
                : []
            ,
            'payment_methods' => 
                isset($payment_methods_allowed['payment_types']) ? 
                $payment_methods_allowed['payment_types']
                : []
        ];

        return $this;
    }

    public function withAutoRecurring(int $frequency, string $frequency_type): self
    {
        if (in_array($frequency_type, ['days', 'months'])) {
            //exception
        }

        $this->auto_recurring['frequency_type'] = $frequency_type;
        $this->auto_recurring['frequency'] = $frequency;

        return $this;
    }

    public function response(): RedirectResponse
    {
        return Redirect::to($this->create(), 303);
    }

    public function toResponse($request): RedirectResponse
    {
        return $this->response();
    }
}
