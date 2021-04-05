<?php


namespace Dboro\LaravelStart\Dto;


use Illuminate\Database\Eloquent\Model;

class UpdateDto extends StartDto
{
    protected Model $model;

    protected array $data;

    public function __construct(Model $model, array $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    public function getModel() : Model
    {
        return $this->model;
    }

    public function getData(): array
    {
        return $this->data;
    }
}