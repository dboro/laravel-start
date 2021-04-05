<?php


namespace Dboro\LaravelStart\Dto;


use Illuminate\Database\Eloquent\Model;

class DestroyDto extends StartDto
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel() : Model
    {
        return $this->model;
    }
}