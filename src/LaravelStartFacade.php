<?php


namespace Dboro\LaravelStart;


use Illuminate\Support\Facades\Facade;

class LaravelStartFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'laravel-base';
    }
}