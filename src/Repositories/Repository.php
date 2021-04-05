<?php


namespace Dboro\LaravelStart\Repositories;


use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function getAll() : array;

    public function find(int $id);

    public function update(Model $model, array $data);

    public function store(array $data);

    public function destroy(Model $model);
}