<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Repositories\Repository;

abstract class StartAction implements Action
{
    protected Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
}