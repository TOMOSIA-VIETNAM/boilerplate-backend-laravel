<?php

namespace Modules\Api\Transforms;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Api\Http\Resources\UserResource;

class UserTransform
{
    public static function collection($users): array
    {
        if ($users instanceof LengthAwarePaginator) {
            return [
                'data' => UserResource::collection($users),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                    'has_more_pages' => $users->hasMorePages(),
                ]
            ];
        }

        return [
            'data' => UserResource::collection($users)
        ];
    }

    public static function single($user, string $message = null): array
    {
        $response = [
            'data' => new UserResource($user)
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return $response;
    }

    public static function success(string $message): array
    {
        return [
            'message' => $message
        ];
    }

    public static function error(string $message, string $error = null): array
    {
        $response = [
            'message' => $message
        ];

        if ($error) {
            $response['error'] = $error;
        }

        return $response;
    }
} 