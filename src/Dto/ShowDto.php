<?php


namespace Dboro\LaravelStart\Dto;


class ShowDto extends StartDto
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }
}