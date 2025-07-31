<?php

namespace App\Containers\Blog\Data\DTOs;

use Illuminate\Http\Request;

/**
 * Update Blog DTO
 * 
 * Data Transfer Object for updating an existing blog post.
 */
class UpdateBlogDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $content = null,
        public readonly ?string $excerpt = null,
        public readonly ?string $featured_image = null,
        public readonly ?string $status = null,
        public readonly ?string $slug = null
    ) {}

    /**
     * Create DTO from request data
     * 
     * @param Request|array $data
     * @return static
     */
    public static function fromRequest($data): static
    {
        $data = is_array($data) ? $data : $data->all();
        
        return new static(
            title: $data['title'] ?? null,
            content: $data['content'] ?? null,
            excerpt: $data['excerpt'] ?? null,
            featured_image: $data['featured_image'] ?? null,
            status: $data['status'] ?? null,
            slug: $data['slug'] ?? null
        );
    }

    /**
     * Get validation rules
     * 
     * @param int|null $blogId
     * @return array
     */
    public static function rules(?int $blogId = null): array
    {
        $slugRule = 'nullable|string';
        
        if ($blogId) {
            $slugRule .= '|unique:blogs,slug,' . $blogId;
        } else {
            $slugRule .= '|unique:blogs,slug';
        }
        
        return [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string',
            'status' => 'nullable|in:draft,published,archived',
            'slug' => $slugRule
        ];
    }

    /**
     * Get only filled attributes
     * 
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featured_image,
            'status' => $this->status,
            'slug' => $this->slug,
        ], fn($value) => !is_null($value));
    }
} 