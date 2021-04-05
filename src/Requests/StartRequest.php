<?php


namespace Dboro\LaravelStart\Requests;


use Dboro\LaravelStart\Dto\Dto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class StartRequest extends FormRequest implements Request
{
    public ?Dto $dto = null;

    protected array $permissions = [];

    protected string $routeParameter = 'id';

    protected ?string $modelClass = null;

    protected ?Model $model;

    abstract protected function initDto();

    protected function canPermissions() : bool
    {
        if (empty($this->permissions)) {
            return true;
        }

        foreach ($this->permissions as $permission) {
            if (auth()->user()->can($permission)) {
                return true;
            }
        }

        return false;
    }

    protected function canModel()
    {
        if (! $this->modelClass) {
            return true;
        }

        /* @var \Illuminate\Database\Eloquent\Model $model */
        $model = new $this->modelClass();
        $this->model = $model::query()->find($this->route()->parameter($this->routeParameter));

        if ($this->model) {
            return true;
        }

        return false;
    }

    public function authorize() : bool
    {
        return $this->canPermissions() && $this->canModel();
    }

    public function getDto(): Dto
    {
        if ($this->dto === null) {
            $this->initDto();
        }

        return $this->dto;
    }

    public function rules()
    {
        return [];
    }
}