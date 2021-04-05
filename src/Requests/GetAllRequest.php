<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\GetAllDto;

class GetAllRequest extends StartRequest
{
    protected function initDto()
    {
        $this->dto = new GetAllDto(request()->exists('page'));
    }
}