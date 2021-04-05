<?php



namespace Dboro\LaravelStart;


use Dboro\LaravelStart\Commands\DeployCommand;
use Dboro\LaravelStart\Commands\StartCopyEntityCommand;
use Dboro\LaravelStart\Commands\StartDeleteEntityCommand;
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

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StartCopyEntityCommand::class,
                StartDeleteEntityCommand::class,
                DeployCommand::class
            ]);
        }
    }
}