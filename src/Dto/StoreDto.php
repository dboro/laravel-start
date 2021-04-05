<?php


namespace Dboro\LaravelStart\Dto;


class StoreDto extends StartDto
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData() : array
    {
        return $this->data;
    }
}