<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\GetAllDto;
use Dboro\LaravelStart\Resources\StartResource;

class GetAllAction extends StartAction
{
    /**
     * @param GetAllDto $dto
     */
    public function run($dto)
    {
        return StartResource::collection($this->repository->getAll())
    }
}