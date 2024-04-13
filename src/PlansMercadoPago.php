<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class PlansMercadoPago implements Responsable
{
    public function __construct(string $product_id)
    {
    }

    public static function make(string $product_id): static
    {
        return new static($product_id);
    }

    public function send()
    {

    }

    public function response(): RedirectResponse
    {
        return Redirect::to($this->send(), 303);
    }

    public function toResponse($request): RedirectResponse
    {
        return $this->response();
    }
}
