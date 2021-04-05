<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\StoreDto;


class StoreRequest extends StartRequest
{
    protected function initDto()
    {
        $this->dto = new StoreDto($this->validated());
    }
}