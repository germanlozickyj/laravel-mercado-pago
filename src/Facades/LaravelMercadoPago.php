<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LaravelMercadoPago\LaravelMercadoPago\LaravelMercadoPago
 */
class LaravelMercadoPago extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LaravelMercadoPago\LaravelMercadoPago\LaravelMercadoPago::class;
    }
}
