<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource
{
    /**
     * @var MetaResource|MetaPaginationResource
     */
    protected $meta;

    /**
     * Resource constructor.
     * @param mixed $resource
     * @param MetaResource|MetaPaginationResource $meta
     */
    public function __construct($resource, $meta)
    {
        $this->meta = $meta;
        parent::__construct($resource);
    }

    /**
     * Get meta.
     *
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'meta' => $this->meta->toArray($request),
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
