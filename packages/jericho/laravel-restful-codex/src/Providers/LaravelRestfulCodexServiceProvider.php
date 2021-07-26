<?php

namespace jericho\LaravelRestfulCodex\Providers;

use Illuminate\Support\ServiceProvider;
use jericho\LaravelRestfulCodex\Services\LaravelRestfulCodexService;

class LaravelRestfulCodexServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            dirname(__DIR__) . '/config/laravelRestfulCodex.php' => config_path('laravelRestfulCodex.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laravel-restful-codex-service', function ($app) {
            return new LaravelRestfulCodexService($app['config']['laravelRestfulCodex']);
        });
    }
}
