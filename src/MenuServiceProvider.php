<?php
namespace TeeLaravel\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (isNotLumen()) {
            $this->publishes([__DIR__ . '/../config/menu.php' => config_path('menu.php')], 'config');
        }
        $this->app->singleton(Menu::class, function ($app) {
            return new Menu($app);
        });
    }

    public function register()
    {
        if (isNotLumen()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/menu.php', 'theme');
        }
    }
}
