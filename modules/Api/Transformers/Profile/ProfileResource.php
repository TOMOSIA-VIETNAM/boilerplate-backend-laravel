<?php

namespace Modules\Api\Transformers\Profile;

use Modules\Api\Transformers\MetaResource;
use Modules\Api\Transformers\Resource;

class ProfileResource extends Resource
{
    /**
     * ProfileResource constructor.
     *
     * @param mixed|null $resource
     * @param int $code
     * @param string $message
     */
    public function __construct($resource = null, $code = 200, string $message = "Successful")
    {
        parent::__construct($resource, new MetaResource($code, $message, null));
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'image_url'  => $this->resource->getImageUrl($this->resource->avatar),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at
        ];
    }
}
