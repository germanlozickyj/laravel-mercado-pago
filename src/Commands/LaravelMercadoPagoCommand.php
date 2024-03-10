<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Commands;

use Illuminate\Console\Command;

class LaravelMercadoPagoCommand extends Command
{
    public $signature = 'laravel-mercado-pago';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
