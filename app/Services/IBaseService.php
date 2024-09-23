<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface IBaseService.
 */
interface IBaseService
{
    /**
     * @return mixed
     */
    public function makeRepo(): mixed;

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function getAll(array $columns): Collection;

    /**
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     *
     * @return Model|null
     */
    public function getById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data = []): ?Model;

    /**
     * @param int $id
     * @param array $data
     * @param array $options
     *
     * @return Model|null
     */
    public function updateById(int $id, array $data, array $options = []): ?Model;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteById(int $id): bool;
}
