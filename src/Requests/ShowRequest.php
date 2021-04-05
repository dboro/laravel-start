<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\ShowDto;


class ShowRequest extends StartRequest
{
    protected function initDto()
    {
        $this->dto = new ShowDto(request()->route($this->routeParameter));
    }
}