<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Request;

class ErrorResource extends Resource
{
    /**
     * @param int $code
     * @param string $message
     * @param null $errors
     * @param null $resource
     * @return array
     */
    public function __construct(int $code, string $message = 'Bad request', $errors = null, $resource = null)
    {
        parent::__construct($resource, new MetaResource($code, $message, $errors));
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
