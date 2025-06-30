<?php

namespace App\Containers\Blog\Actions;

use App\Core\Actions\BaseAction;
use App\Containers\Blog\Models\Blog;
use App\Containers\Blog\Repositories\IBlogRepository;

/**
 * Get Blog By ID Action
 * 
 * Handles retrieving a specific blog by ID.
 */
class GetBlogByIdAction extends BaseAction
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
     * @param int $id
     * @return Blog|null
     */
    public function execute(int $id): ?Blog
    {
        return $this->blogRepository->findById($id)->load('user');
    }
} 