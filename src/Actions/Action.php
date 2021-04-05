<?php


namespace Dboro\LaravelStart\Actions;


use Dboro\LaravelStart\Dto\Dto;

interface Action
{
    public function run(?Dto $dto);
}