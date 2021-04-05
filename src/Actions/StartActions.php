<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\DestroyDto;
use Dboro\LaravelStart\Dto\GetAllDto;
use Dboro\LaravelStart\Dto\ShowDto;
use Dboro\LaravelStart\Dto\StoreDto;
use Dboro\LaravelStart\Dto\UpdateDto;
use Dboro\LaravelStart\Repositories\Repository;

class StartActions
{
    protected Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(GetAllDto $dto) : array
    {
        return (new GetAllAction($this->repository))->run($dto);
    }

    public function find(ShowDto $dto)
    {
        return (new FindAction($this->repository))->run($dto);
    }

    public function update(UpdateDto $dto)
    {
        return (new UpdateAction($this->repository))->run($dto);
    }

    public function store(StoreDto $dto)
    {
        return (new StoreAction($this->repository))->run($dto);
    }

    public function destroy(DestroyDto $dto)
    {
        return (new DestroyAction($this->repository))->run($dto);
    }
}