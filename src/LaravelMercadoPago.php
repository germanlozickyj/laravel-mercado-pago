<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Support\Facades\Http;

class LaravelMercadoPago
{
    const API_URL = 'https://api.mercadopago.com';

    public static function api(string $method, string $uri, array $payload = [])
    {
        if (empty(config('mercado-pago.access_token'))) {
            //mercado pago exception
        }

        $access_token = config('mercado-pago.access_token');

        $response = Http::withToken($access_token)
            ->accept('application/json')
            ->contentType('application/json')
            ->$method(static::API_URL."/$uri", $payload);

        if ($response->failed()) {
            //mercado pago exception
        }

        return $response;
    }
}
