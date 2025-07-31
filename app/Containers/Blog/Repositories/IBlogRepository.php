<?php

namespace App\Containers\Blog\Repositories;

use App\Core\Repositories\IBaseRepository;
use App\Containers\Blog\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Blog Repository Interface
 * 
 * Defines the contract for blog data access operations.
 */
interface IBlogRepository extends IBaseRepository
{
    /**
     * Get blogs with filters and pagination
     * 
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getWithFilters(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    /**
     * Get published blogs
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPublished(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get blogs by user ID
     * 
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByUserId(int $userId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get blog by slug
     * 
     * @param string $slug
     * @return Blog|null
     */
    public function findBySlug(string $slug): ?Blog;

    /**
     * Get blogs by status
     * 
     * @param string $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByStatus(string $status, int $perPage = 10): LengthAwarePaginator;

    /**
     * Search blogs by title or content
     * 
     * @param string $query
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(string $query, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get recent blogs
     * 
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 5): Collection;

    /**
     * Get popular blogs (by views or other metrics)
     * 
     * @param int $limit
     * @return Collection
     */
    public function getPopular(int $limit = 5): Collection;
} 