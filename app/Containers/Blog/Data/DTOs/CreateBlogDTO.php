<?php

namespace App\Containers\Blog\Data\DTOs;

use Illuminate\Http\Request;

/**
 * Create Blog DTO
 * 
 * Data Transfer Object for creating a new blog post.
 */
class CreateBlogDTO
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $title,
        public readonly string $content,
        public readonly ?string $excerpt = null,
        public readonly ?string $featured_image = null,
        public readonly string $status = 'draft',
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
            user_id: $data['user_id'] ?? auth()->id(),
            title: $data['title'],
            content: $data['content'],
            excerpt: $data['excerpt'] ?? null,
            featured_image: $data['featured_image'] ?? null,
            status: $data['status'] ?? 'draft',
            slug: $data['slug'] ?? null
        );
    }

    /**
     * Get validation rules
     * 
     * @return array
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string',
            'status' => 'nullable|in:draft,published,archived',
            'slug' => 'nullable|string|unique:blogs,slug'
        ];
    }
} 