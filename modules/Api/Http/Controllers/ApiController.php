<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Api\Transformers\Resource;

class ApiController
{
    /**
     * @param array|Resource
     * @return JsonResponse
     */
    public function response(array|Resource $resource = null, int $status = 200): JsonResponse
    {
        return response()->json($resource, $status);
    }
}
