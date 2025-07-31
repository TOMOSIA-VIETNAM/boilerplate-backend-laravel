<?php

namespace App\Core\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBaseRepository
{
    /**
     * The repository model.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected Builder $query;

    /**
     * Alias for the query limit.
     *
     * @var int|null
     */
    protected ?int $take = null;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected array $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    protected array $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    protected array $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    protected array $scopes = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model|mixed
     *
     * @throws Exception
     */
    public function makeModel(): mixed
    {
        $model = app()->make($this->model());

        if (! $model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of ".Model::class);
        }

        return $this->model = $model;
    }

    /**
     * @param array $columns
     * @return Model|Builder|null
     */
    public function first(array $columns = ['*']): Model|Builder|null
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->first($columns);

        $this->unsetClauses();

        return $model;
    }

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        $this->newQuery()->eagerLoad();

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }

    /**
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * @param int $id
     * @param array $columns
     * @return Model|null
     */
    public function findById(int $id, array $columns = ['*']): ?Model
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($id, $columns);
    }

    /**
     * @param int $modelId
     *
     * @return Model|null
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * @param int $modelId
     *
     * @return Model|null
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        $this->unsetClauses();
        $model = $this->model->create($data);

        return $model->fresh();
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): ?Model
    {
        $this->unsetClauses();
        $model = $this
            ->model
            ->query()
            ->updateOrCreate($attributes, $values);

        return $model->fresh();
    }

    /**
     * @param int $modelId
     * @param array $data
     * @param array $options
     *
     * @return Model|null
     */
    public function updateById(int $modelId, array $data, array $options = []): ?Model
    {
        $this->unsetClauses();

        $model = $this->findById($modelId);

        $model->update($data, $options);

        return $model->fresh();
    }

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        $this->unsetClauses();

        return $this->findById($modelId)->delete();
    }

    /**
     * @param array $ids
     *
     * @return int
     */
    public function deleteMultipleById(array $ids): int
    {
        $this->unsetClauses();

        return $this->model->destroy($ids);
    }

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        $this->unsetClauses();

        return $this->findTrashedById($modelId)->restore();
    }

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        $this->unsetClauses();

        return $this->findTrashedById($modelId)->forceDelete();
    }

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }

    /**
     * @param int $limit
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit): static
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * @param array|string $column
     * @param mixed $value
     * @param string $operator
     *
     * @return $this
     */
    public function where(array|string $column, mixed $value = null, string $operator = '='): static
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * @param string $column
     * @param mixed $values
     *
     * @return $this
     */
    public function whereIn(string $column, mixed $values): static
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $this->newQuery()->setClauses()->setScopes();

        $count = $this->query->count();

        $this->unsetClauses();

        return $count;
    }

    /**
     * @return $this
     */
    protected function newQuery(): static
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * @return $this
     */
    protected function eagerLoad(): static
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setClauses(): static
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orderBy) {
            $this->query->orderBy($orderBy['column'], $orderBy['direction']);
        }

        if (isset($this->take) and ! is_null($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setScopes(): static
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(...$args);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function unsetClauses(): static
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;

        return $this;
    }

    /**
     * @param string $scope
     * @param array $args
     *
     * @return $this
     */
    public function __call(string $scope, array $args)
    {
        $this->scopes[$scope] = $args;

        return $this;
    }
} 