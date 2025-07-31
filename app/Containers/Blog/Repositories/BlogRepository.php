<?php

namespace App\Containers\Blog\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Containers\Blog\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Blog Repository Implementation
 * 
 * Implements blog data access operations.
 */
class BlogRepository extends BaseRepository implements IBlogRepository
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return Blog::class;
    }

    /**
     * Get blogs with filters and pagination
     * 
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getWithFilters(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('user');

        // Filter by user
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by search query
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by date range
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Get published blogs
     * 
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPublished(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get blogs by user ID
     * 
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get blog by slug
     * 
     * @param string $slug
     * @return Blog|null
     */
    public function findBySlug(string $slug): ?Blog
    {
        return $this->model->with('user')
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Get blogs by status
     * 
     * @param string $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByStatus(string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Search blogs by title or content
     * 
     * @param string $query
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(string $query, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%')
                  ->orWhere('excerpt', 'like', '%' . $query . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get recent blogs
     * 
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 5): Collection
    {
        return $this->model->with('user')
            ->published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get popular blogs (by views or other metrics)
     * 
     * @param int $limit
     * @return Collection
     */
    public function getPopular(int $limit = 5): Collection
    {
        return $this->model->with('user')
            ->published()
            ->orderBy('created_at', 'desc') // For now, just order by creation date
            ->limit($limit)
            ->get();
    }
} 