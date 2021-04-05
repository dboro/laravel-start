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
        if ($dto->getIsPaginate()) {

        }
        else {
            return [
                'data' => StartResource::collection($this->repository->getAll())
            ];
        }
    }
}