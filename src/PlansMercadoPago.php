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

    public function create($payment_methods_allowed = [], $custom_auto_recurring = [])
    {

    }
    
    public function withAutoRecurring(int $frequency, string $frequency_type) : self
    {
        if(in_array($frequency_type, ['days', 'months'])) {
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
