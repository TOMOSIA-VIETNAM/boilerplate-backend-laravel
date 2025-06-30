<?php

namespace App\Containers\Blog\Actions;

use App\Core\Actions\BaseAction;
use App\Containers\Blog\Data\DTOs\UpdateBlogDTO;
use App\Containers\Blog\Models\Blog;
use App\Containers\Blog\Repositories\IBlogRepository;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Update Blog Action
 * 
 * Handles the updating of existing blog posts.
 */
class UpdateBlogAction extends BaseAction
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
     * @param UpdateBlogDTO $dto
     * @return Blog|null
     * @throws Exception
     */
    public function execute(int $id, UpdateBlogDTO $dto): ?Blog
    {
        try {
            DB::beginTransaction();

            $blog = $this->blogRepository->findById($id);
            if (!$blog) {
                return null;
            }

            $updateData = $dto->toArray();
            
            // Handle status change
            if (isset($updateData['status'])) {
                if ($updateData['status'] === 'published' && $blog->status !== 'published') {
                    $blog->publish();
                    unset($updateData['status']); // Remove from update data since publish() handles it
                } elseif ($updateData['status'] === 'archived' && $blog->status !== 'archived') {
                    $blog->archive();
                    unset($updateData['status']); // Remove from update data since archive() handles it
                }
            }

            // Update other fields
            if (!empty($updateData)) {
                $this->blogRepository->update($id, $updateData);
            }

            DB::commit();

            return $this->blogRepository->findById($id)->load('user');

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 