<?php

namespace App\Containers\Blog\Actions;

use App\Core\Actions\BaseAction;
use App\Containers\Blog\Repositories\IBlogRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Get Blogs Action
 * 
 * Handles retrieving blogs with filters and pagination.
 */
class GetBlogsAction extends BaseAction
{
    public function __construct(
        private readonly IBlogRepository $blogRepository
    ) {}

    /**
     * Specify Repository class name.
     *
     * @return string
     */
    public function repo(): string
    {
        return IBlogRepository::class;
    }

    /**
     * Execute the action
     * 
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function execute(array $filters = []): LengthAwarePaginator
    {
        $perPage = $filters['per_page'] ?? 10;
        unset($filters['per_page']);

        return $this->blogRepository->getWithFilters($filters, $perPage);
    }
} 