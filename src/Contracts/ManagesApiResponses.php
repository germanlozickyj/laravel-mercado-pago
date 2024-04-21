<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Contracs;

use Illuminate\Support\Facades\Http;

interface ManagesApiResponses
{
    public function handleStatusCode(Http $response);

    public function handleResponse(Http $response);
}
