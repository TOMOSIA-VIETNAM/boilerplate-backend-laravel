<?php

namespace Modules\Api\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Success Response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse(mixed $data, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];

        if ($data instanceof ResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $response['data'] = $data->response()->getData(true)['data'];
            $response['meta'] = [
                'current_page' => $data->resource->currentPage(),
                'last_page' => $data->resource->lastPage(),
                'per_page' => $data->resource->perPage(),
                'total' => $data->resource->total()
            ];
        } elseif ($data instanceof JsonResource) {
            $response['data'] = $data->response()->getData(true)['data'];
        }

        return response()->json($response, $code);
    }

    /**
     * Error Response
     *
     * @param string $message
     * @param int $code
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $code = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Validation Error Response
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    protected function validationErrorResponse(mixed $errors, string $message = 'Validation Error'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * Not Found Response
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource Not Found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Unauthorized Response
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Forbidden Response
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }
} 