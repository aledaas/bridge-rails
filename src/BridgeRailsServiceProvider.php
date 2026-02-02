<?php

namespace Aledaas\BridgeRails;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider;

class BridgeRailsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bridge-rails.php', 'bridge-rails');

        $this->app->singleton(BridgeClient::class, function ($app) {
            /** @var ConfigRepository $config */
            $config = $app->make('config');

            return new BridgeClient(
                baseUrl: (string) $config->get('bridge-rails.base_url'),
                apiKey: (string) $config->get('bridge-rails.api_key'),
                apiPrefix: (string) $config->get('bridge-rails.api_prefix', '/v0'),
                timeoutSeconds: (int) $config->get('bridge-rails.timeout_seconds', 30),
                retries: (int) $config->get('bridge-rails.retries', 2),
                retrySleepMs: (int) $config->get('bridge-rails.retry_sleep_ms', 200),
            );
        });

        $this->app->singleton(Bridge::class, function ($app) {
            return new Bridge($app->make(BridgeClient::class));
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/bridge-rails.php' => $this->app->configPath('bridge-rails.php'),
        ], 'bridge-rails-config');
    }
}
