<?php

namespace Modules\Api\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Api\Transformers\ErrorResource;
use Symfony\Component\HttpFoundation\Response as ExceptionResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (ApiException $e, $request) {
            return $this->makeErrorResponse($e->getCode(), $e->getMessage(), null, $e->getData());
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param Request $request
     * @param ValidationException $e
     * @return Response|JsonResponse
     */
    protected function invalidJson($request, ValidationException $e): Response | JsonResponse
    {
        /** @var mixed|Response|JsonResponse */
        $resource = $this->makeErrorResponse($e->status, $e->getMessage(), $e->errors());
        $dataResource = $resource->getData();
        if ($dataResource && empty($dataResource->data) && is_array($dataResource->data)) {
            $dataResource->data = null;
            $dataResource->meta->message = trans('errors.invalid_data');
            $resource->setData($dataResource);
        }

        return $resource;
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  Request  $request
     * @param Throwable $e
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        if (config('app.debug')) {
            return $this->makeErrorResponse(500, trans('errors.server_error'), $this->convertExceptionToArray($e));
        }

        return $this->makeErrorResponse(500, trans('errors.server_error'));
    }

    /**
     * @param int $code
     * @param string $message
     * @param array|null $errors
     * @param mixed|null $data
     * @return JsonResponse
     */
    protected function makeErrorResponse(int $code, string $message, ?array $errors = null, mixed $data = null): JsonResponse
    {
        return (new ErrorResource($code, $message, $errors, $data))->response()->setStatusCode($code);
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse | Response
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->makeErrorResponse(ExceptionResponse::HTTP_NOT_FOUND, trans('errors.page_not_found'));
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->makeErrorResponse(ExceptionResponse::HTTP_NOT_FOUND, __('Not Found'));
        }

        return parent::render($request, $e);
    }
}
