<?php

namespace LaravelMercadoPago\LaravelMercadoPago\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelMercadoPago\LaravelMercadoPago\LaravelMercadoPagoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
<<<<<<< HEAD
use LaravelMercadoPago\LaravelMercadoPago\LaravelMercadoPagoServiceProvider;
=======
>>>>>>> 62d2369fac0c61e184f22e85212d4b4fa665c757

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LaravelMercadoPago\\LaravelMercadoPago\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelMercadoPagoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-mercado-pago_table.php.stub';
        $migration->up();
        */
    }
}
