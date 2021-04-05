<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\DestroyDto;

class DestroyAction extends StartAction
{
    /**
     * @param DestroyDto $dto
     */
    public function run($dto)
    {
        return $this->repository->destroy($dto->getModel());
    }
}