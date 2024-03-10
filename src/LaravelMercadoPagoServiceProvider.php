<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use LaravelMercadoPago\LaravelMercadoPago\Commands\LaravelMercadoPagoCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMercadoPagoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-mercado-pago')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-mercado-pago_table')
            ->hasCommand(LaravelMercadoPagoCommand::class);
    }
}
