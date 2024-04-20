<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Contracs;

interface ManagesApiResponses
{
    public function HandleStatusCode();

    public function HandleExpection();

    public function HandleResponse();

    public function resolve();
}
