<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\UpdateDto;

class UpdateAction extends StartAction
{
    /**
     * @param UpdateDto $dto
     */
    public function run($dto)
    {
        return $this->repository->update($dto->getModel(), $dto->getData());
    }
}