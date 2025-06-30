<?php

namespace App\Containers\Blog\Actions;

use App\Core\Actions\BaseAction;
use App\Containers\Blog\Data\DTOs\CreateBlogDTO;
use App\Containers\Blog\Models\Blog;
use App\Containers\Blog\Repositories\IBlogRepository;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Create Blog Action
 * 
 * Handles the creation of new blog posts.
 */
class CreateBlogAction extends BaseAction
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
     * @param CreateBlogDTO $dto
     * @return Blog
     * @throws Exception
     */
    public function execute(CreateBlogDTO $dto): Blog
    {
        try {
            DB::beginTransaction();

            $blog = $this->blogRepository->create([
                'user_id' => $dto->user_id,
                'title' => $dto->title,
                'content' => $dto->content,
                'excerpt' => $dto->excerpt,
                'featured_image' => $dto->featured_image,
                'status' => $dto->status,
                'slug' => $dto->slug,
            ]);

            // If status is published, set published_at
            if ($dto->status === 'published') {
                $blog->publish();
            }

            DB::commit();

            return $blog->load('user');

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 