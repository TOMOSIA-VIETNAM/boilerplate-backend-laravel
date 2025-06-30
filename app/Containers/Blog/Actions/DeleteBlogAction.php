<?php

namespace App\Containers\Blog\Actions;

use App\Core\Actions\BaseAction;
use App\Containers\Blog\Repositories\IBlogRepository;
use Exception;

/**
 * Delete Blog Action
 * 
 * Handles the deletion of blog posts.
 */
class DeleteBlogAction extends BaseAction
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
     * @return bool
     * @throws Exception
     */
    public function execute(int $id): bool
    {
        try {
            $blog = $this->blogRepository->findById($id);
            if (!$blog) {
                return false;
            }

            return $this->blogRepository->delete($id);

        } catch (Exception $e) {
            throw $e;
        }
    }
} 