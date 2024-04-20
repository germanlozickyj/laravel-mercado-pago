<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Support\Facades\Http;
use LaravelMercadoPago\LaravelMercadoPago\Contracs\ManagesApiResponses;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class LaravelMercadoPago implements ManagesApiResponses
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

        self::handleStatusCode($response);
        self::handleExpection($response);

        return self::handleResponse($response);
    }

    public static function formatAmount(int $amount, string $currency, ?string $locale = null, array $options = []): string
    {
        $money = new Money($amount, new Currency(strtoupper($currency)));

        $locale = $locale ?? config('lemon-squeezy.currency_locale');

        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        if (isset($options['min_fraction_digits'])) {
            $numberFormatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $options['min_fraction_digits']);
        }

        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($money);
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
}
