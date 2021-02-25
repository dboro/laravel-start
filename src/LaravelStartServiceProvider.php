<?php


namespace Dboro\LaravelStart;


use Illuminate\Support\ServiceProvider;

class LaravelStartServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы приложения.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LaravelStart::class, function () {
            return new LaravelStart();
        });

        $this->app->alias(LaravelStart::class, 'laravel-start');
    }
}