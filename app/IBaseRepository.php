<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    /**
     * @param array $columns
     * @return Model|Builder|null
     */
    public function first(array $columns = ['*']): Model|Builder|null;

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * @return Collection
     */
    public function allTrashed(): Collection;

    /**
     * @param int $id
     * @param array $columns
     *
     * @return Model|null
     */
    public function findById(int $id, array $columns = ['*']): ?Model;

    /**
     * @param int $modelId
     *
     * @return Model|null
     */
    public function findTrashedById(int $modelId): ?Model;

    /**
     * @param int $modelId
     *
     * @return Model|null
     */
    public function findOnlyTrashedById(int $modelId): ?Model;

    /**
     * @param array $data
     *
     * @return Model|null
     */
    public function create(array $data): ?Model;

    /**
     * @param int $modelId
     * @param array $data
     * @param array $options
     *
     * @return Model|null
     */
    public function updateById(int $modelId, array $data, array $options = []): ?Model;

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function deleteById(int $modelId): bool;

    /**
     * @param array $ids
     *
     * @return int
     */
    public function deleteMultipleById(array $ids): int;

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function restoreById(int $modelId): bool;

    /**
     * @param int $modelId
     *
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool;

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection;

    /**
     * @param int $limit
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 25, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator;

    /**
     * @param int $limit
     *
     * @return mixed
     */
    public function limit(int $limit): mixed;

    /**
     * @param string $column
     * @param string $direction
     *
     * @return mixed
     */
    public function orderBy(string $column, string $direction = 'asc'): mixed;

    /**
     * @param array|string $column
     * @param mixed $value
     * @param string $operator
     *
     * @return mixed
     */
    public function where(array|string $column, mixed $value = null, string $operator = '='): mixed;

    /**
     * @param string $column
     * @param mixed $values
     *
     * @return mixed
     */
    public function whereIn(string $column, mixed $values): mixed;

    /**
     * @return int
     */
    public function count(): int;
}
