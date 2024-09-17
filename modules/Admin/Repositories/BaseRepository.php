<?php

namespace Modules\Admin\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository.
 *
 * Modified from: https://github.com/kylenoland/laravel-base-repository
 */
abstract class BaseRepository
{
    const PER_PAGE_15 = 15;
    const PER_PAGE_30 = 30;

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
    protected ?int $take;

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
     * Get all the model records in the database.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $this->newQuery()->eagerLoad();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Count the number of specified model records in the database.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Get the first specified model record from the database.
     *
     * @return Model|null
     */
    public function first(): ?Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->first();

        $this->unsetClauses();

        return $model;
    }

    /**
     * Get the first specified model record from the database or throw an exception if not found.
     *
     * @return Model
     */
    public function firstOrFail(): Model
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail();

        $this->unsetClauses();

        return $model;
    }

    /**
     * Get all the specified model records in the database.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Get the specified model record from the database.
     *
     * @param int|string $id Id
     *
     * @return Model|null
     */
    public function getById($id): ?Model
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($id);
    }

    /**
     * @param mixed $item Item
     * @param mixed $column Column
     * @param  array $columns Column
     *
     * @return Builder|Model|object|null
     */
    public function getByColumn($item, $column, array $columns = ['*'])
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->where($column, $item)->first($columns);
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param  int|string $id Id
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteById($id): ?bool
    {
        $this->unsetClauses();

        $model = $this->getById($id);
        if ($model) {
            return $model->delete();
        }

        return false;
    }

    /**
     * Set the query limit.
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit): BaseRepository
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set an ORDER BY clause.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc'): BaseRepository
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * @param int $limit
     * @param array  $columns
     * @param string $pageName
     * @param null   $page
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', $page = null): LengthAwarePaginator
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->paginate($limit, $columns, $pageName, $page);

        $this->unsetClauses();

        return $models;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column
     * @param string|int $value
     * @param string $operator
     *
     * @return $this
     */
    public function where(string $column, $value, string $operator = '='): BaseRepository
    {
        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param string $column
     * @param mixed  $values
     *
     * @return $this
     */
    public function whereIn(string $column, $values): BaseRepository
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param mixed $relations Relations
     *
     * @return $this
     */
    public function with($relations): BaseRepository
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return $this
     */
    protected function newQuery(): BaseRepository
    {
        $this->query = $this->model->newQuery();

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad(): BaseRepository
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses(): BaseRepository
    {
        foreach ($this->wheres as $where) {
            $this->query->where($where['column'], $where['operator'], $where['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and ! empty($this->take)) {
            $this->query->take($this->take);
        }

        return $this;
    }

    /**
     * Set query scopes.
     *
     * @return $this
     */
    protected function setScopes(): BaseRepository
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses(): BaseRepository
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->take = null;

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @param int $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(int $id, array $attributes = [])
    {
        $result = $this->getById($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * @param int|string $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id)
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->find($id);
    }

    /**
     * @param int|string $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findOrFail($id)
    {
        $this->unsetClauses();

        $this->newQuery()->eagerLoad();

        return $this->query->findOrFail($id);
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
     * @return \Illuminate\Database\Eloquent\Model|static
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
}
