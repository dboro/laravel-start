<?php

namespace Dboro\LaravelStart\Repositories;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class StartRepository implements Repository
{
    abstract protected function model() : string;

    protected ?string $defaultSort = null;

    protected ?array $allowSorts = null;

    protected ?array $allowFields = null;

    protected ?array $allowIncludes = null;

    protected ?array $allowFilters = null;

    public function getIncludesRepositories()
    {
        return [];
    }

    public function getModel()
    {
        return $this->model();
    }

    protected function query() : QueryBuilder
    {
        $query = QueryBuilder::for($this->model());
        //$this->setAllowsRecursive();

        if ($this->defaultSort) {
            $query = $query->defaultSort($this->defaultSort);
        }

        if ($this->allowSorts) {
            $query = $query->allowedSorts($this->allowSorts);
        }

        if ($this->allowFields) {
            $query = $query->allowedFields($this->allowFields);
        }

        if ($this->allowIncludes) {
            $query = $query->allowedIncludes($this->allowIncludes);
        }

        if ($this->allowFilters) {
            $query = $query->allowedFilters($this->allowFilters);
        }

        return $query;
    }

    public function getAllowIncludes()
    {
        return $this->allowIncludes;
    }

    public function getAllowFields()
    {
        return $this->allowFields;
    }

    protected function setAllowsRecursive()
    {
        $repositories = $this->getIncludesRepositories();

        function recursive($models, $repositories, &$allowFields, &$allowIncludes, $prefix = '') {

            foreach ($repositories as $include => $repository) {

                /* @var \Dboro\LaravelStart\Repositories\Repository $includeRepository */
                $includeRepository = new $repository;

                if (in_array($includeRepository->getModel(), $models)) {
                    continue;
                }
                else {
                    $models[] = $includeRepository->getModel();
                }

                $addingAllowFiedls = $includeRepository->getAllowFields();
                $addingAllowIncludes = $includeRepository->getAllowIncludes();

                $prefix .= $include . '.';

                if ($addingAllowFiedls) {
                    $allowFields = array_merge(
                        $allowFields, array_map(function ($allowField) use($prefix) {
                            return $prefix . $allowField;
                        }, $addingAllowFiedls)
                    );
                }

                if ($addingAllowIncludes) {
                    $allowIncludes = array_merge(
                        $allowIncludes, array_map(function ($allowInclude) use($prefix) {
                            return $prefix . $allowInclude;
                        }, $addingAllowIncludes)
                    );
                }

                $nestedRepositories = $includeRepository->getIncludesRepositories();

                if ($nestedRepositories) {
                    recursive($models, $nestedRepositories, $allowFields, $allowIncludes, $prefix);
                }
            }
        }

        recursive([$this->model()], $repositories, $this->allowFields, $this->allowIncludes);
        //dd($this->allowFields, $this->allowIncludes);
    }

    public function getAll() : array
    {
        return $this->query()->get()->all();
    }

    public function find(int $id)
    {
        return $this->query()->find($id);
    }

    public function update(Model $model, array $data)
    {
        $model->fill($data);

        if ($model->save()) {
            return $model;
        }
        else {
            return false;
        }
    }

    public function store(array $data)
    {
        /* @var \Illuminate\Database\Eloquent\Model $model */
        $class = $this->getModel();
        $model = new $class;
        $model->fill($data);

        if ($model->save()) {
            return $model;
        }
        else {
            return false;
        }
    }

    public function destroy(Model $model) : bool
    {
        return $model->delete();
    }
}