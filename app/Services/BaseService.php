<?php

namespace App\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements IBaseService
{
    protected $repo;

    /**
     * Specify Repository class name.
     *
     * @return mixed
     */
    abstract public function repo(): mixed;

    /**
     * BaseIBaseService constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->makeRepo();
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function makeRepo(): mixed
    {
        $repo = app()->make($this->repo());

        return $this->repo = $repo;
    }

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data = []): ?Model
    {
        return $this->repo->create($data);
    }

    /**
     * Get all the model records in the database.
     *
     * @param array $columns
     * @return Collection
     */
    public function getAll(array $columns = ['*']): Collection
    {
        return $this->repo->all($columns);
    }

    /**
     * Get the specified model record from the database.
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     *
     * @return Model|null
     */
    public function getById(int $modelId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->repo->with($relations)->findById($modelId, $columns);
    }

    /**
     * Update the specified model record in the database.
     *
     * @param $id
     * @param array $data
     * @param array $options
     * @return Model|null
     */
    public function updateById($id, array $data, array $options = []): ?Model
    {
        return $this->repo->updateById($id, $data, $options);
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        return $this->repo->deleteById($id);
    }
}
