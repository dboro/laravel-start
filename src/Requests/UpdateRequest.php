<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\UpdateDto;


class UpdateRequest extends StartRequest
{
    protected function initDto()
    {
        $this->dto = new UpdateDto($this->model, $this->validated());
    }
}