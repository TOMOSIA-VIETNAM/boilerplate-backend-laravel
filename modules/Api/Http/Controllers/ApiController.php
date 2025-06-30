<?php

namespace Modules\Api\Http\Controllers;

use App\Containers\Api\Actions\CreateApiAction;
use App\Containers\Api\Actions\UpdateApiAction;
use App\Containers\Api\Actions\DeleteApiAction;
use App\Containers\Api\Data\DTOs\CreateApiDTO;
use App\Containers\Api\Data\DTOs\UpdateApiDTO;
use App\Containers\Api\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\CreateApiRequest;
use Modules\Api\Http\Requests\UpdateApiRequest;
use Modules\Api\Http\Resources\ApiResource;

/**
 * API Management Controller for API Module
 * 
 * Handles API management operations including CRUD operations,
 * filtering, key regeneration, and status management.
 * Provides comprehensive API administration functionality.
 */
class ApiController extends Controller
{
    /**
     * Constructor with dependency injection
     * 
     * @param ApiService $service
     * @param CreateApiAction $createAction
     * @param UpdateApiAction $updateAction
     * @param DeleteApiAction $deleteAction
     */
    public function __construct(
        protected ApiService $service,
        protected CreateApiAction $createAction,
        protected UpdateApiAction $updateAction,
        protected DeleteApiAction $deleteAction
    ) {}

    /**
     * Get paginated list of APIs with optional filters
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['type', 'client_id', 'status', 'date_from', 'date_to']);
        $perPage = $request->get('per_page', 10);

        $apis = $this->service->getWithFilters($filters, $perPage);

        return $this->successResponse(
            ApiResource::collection($apis)
        );
    }

    /**
     * Create a new API
     * 
     * @param CreateApiRequest $request
     * @return JsonResponse
     */
    public function store(CreateApiRequest $request): JsonResponse
    {
        $dto = CreateApiDTO::fromRequest($request->validated());
        $api = $this->createAction->execute($dto);

        return $this->successResponse(
            new ApiResource($api),
            'API created successfully'
        );
    }

    /**
     * Get a specific API by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $api = $this->service->findById($id);

        if (!$api) {
            return $this->notFoundResponse('API not found');
        }

        return $this->successResponse(
            new ApiResource($api)
        );
    }

    /**
     * Update a specific API
     * 
     * @param UpdateApiRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateApiRequest $request, int $id): JsonResponse
    {
        $dto = UpdateApiDTO::fromRequest($request->validated());
        $api = $this->updateAction->execute($id, $dto);

        return $this->successResponse(
            new ApiResource($api),
            'API updated successfully'
        );
    }

    /**
     * Delete a specific API
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->deleteAction->execute($id);

        if (!$deleted) {
            return $this->errorResponse('Failed to delete API', 500);
        }

        return $this->successResponse(
            null,
            'API deleted successfully'
        );
    }

    /**
     * Get APIs filtered by type
     * 
     * @param string $type
     * @return JsonResponse
     */
    public function getByType(string $type): JsonResponse
    {
        $apis = $this->service->getByType($type);

        return $this->successResponse(
            ApiResource::collection($apis)
        );
    }

    /**
     * Get APIs filtered by client ID
     * 
     * @param int $clientId
     * @return JsonResponse
     */
    public function getByClient(int $clientId): JsonResponse
    {
        $apis = $this->service->getByClient($clientId);

        return $this->successResponse(
            ApiResource::collection($apis)
        );
    }

    /**
     * Get APIs with associated logs
     * 
     * @return JsonResponse
     */
    public function getWithLogs(): JsonResponse
    {
        $apis = $this->service->getWithLogs();

        return $this->successResponse(
            ApiResource::collection($apis)
        );
    }

    /**
     * Regenerate API key for a specific API
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function regenerateKey(int $id): JsonResponse
    {
        $api = $this->service->regenerateKey($id);

        return $this->successResponse(
            new ApiResource($api),
            'API key regenerated successfully'
        );
    }

    /**
     * Update status of a specific API
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive'
        ]);

        $api = $this->service->updateStatus($id, $request->status);

        return $this->successResponse(
            new ApiResource($api),
            'API status updated successfully'
        );
    }

    /**
     * Get APIs that have exceeded rate limits
     * 
     * @return JsonResponse
     */
    public function getWithRateLimitExceeded(): JsonResponse
    {
        $apis = $this->service->getWithRateLimitExceeded();

        return $this->successResponse(
            ApiResource::collection($apis)
        );
    }
} 