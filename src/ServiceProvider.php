<?php

namespace FredCardoso\Laravel\Logging\GoogleCloudDriver;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use FredCardoso\Laravel\Logging\GoogleCloudDriver\Log\Handler;
use Monolog\Logger;

/**
 * Class Service Provider
 *
 * @package     fred-cardoso/laravel-google-cloud-logging-driver
 * @author      Frederico Cardoso <geral@fredcardoso.pt>
 * @license     The MIT license
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Log::extend('google', function ($app, array $config) {
            $handler = new Handler(
                $config['labels'],
                $config['name'],
                $config['level'] ?? 'warning',
                $config['bubble'] ?? true
            );

            return new Logger($config['name'] ?? $app->environment(), [$handler]);
        });
    }
}
