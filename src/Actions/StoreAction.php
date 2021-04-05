<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\StoreDto;

class StoreAction extends StartAction
{
    /**
     * @param StoreDto $dto
     */
    public function run($dto)
    {
        return $this->repository->store($dto->getData());
    }
}