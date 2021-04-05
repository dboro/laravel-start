<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\DestroyDto;


class DestroyRequest extends StartRequest
{
    protected function initDto()
    {
        $this->dto = new DestroyDto($this->model);
    }
}