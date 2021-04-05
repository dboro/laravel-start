<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\Dto;

interface Request
{
    public function getDto() : Dto;
}