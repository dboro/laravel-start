<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\ShowDto;
use Dboro\LaravelStart\Resources\StartResource;

class FindAction extends StartAction
{
    /**
     * @param ShowDto $dto
     */
    public function run($dto)
    {
        return [
            'data' => new StartResource($this->repository->find($dto->getId()))
        ];
    }
}