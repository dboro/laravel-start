<?php


namespace Dboro\LaravelStart\Dto;


/**
 * Class GetAllDto
 * @package Dboro\LaravelStart\Dto
 */

class GetAllDto extends StartDto
{
    protected bool $isPaginate;

    public function __construct(bool $isPaginate)
    {
        $this->isPaginate = $isPaginate;
    }

    public function getIsPaginate() : bool
    {
        return $this->isPaginate;
    }
}