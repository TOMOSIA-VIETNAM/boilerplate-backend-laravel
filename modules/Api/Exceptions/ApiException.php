<?php

namespace Modules\Api\Exceptions;

use RuntimeException;
use Throwable;

class ApiException extends RuntimeException
{
    /** @var mixed|null  */
    private mixed $data;

    /**
     * ApiException constructor.
     *
     * @param int $httpCode
     * @param string $message
     * @param mixed|null $data
     * @param Throwable|null $previous
     */
    public function __construct(int $httpCode, string $message, $data = null, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $httpCode, $previous);
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function serviceUnavailable(string $message = 'Service Unavailable', $data = null): ApiException
    {
        return new ApiException(503, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function badRequest(string $message = "Bad Request", $data = null): ApiException
    {
        return new ApiException(400, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function forbidden(string $message = "Forbidden", $data = null): ApiException
    {
        return new ApiException(403, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @param array $errors
     * @return ApiException
     */
    public static function validation(string $message = "Bad Request", $data = null, array $errors = []): ApiException
    {
        return new ApiException(422, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function notFound(string $message = "Not Found", $data = null): ApiException
    {
        return new ApiException(404, $message, $data);
    }

    /**
     * @param string $message
     * @param mixed|null $data
     * @return ApiException
     */
    public static function unAuthenticated(string $message = "UnAuthenticated", $data = null): ApiException
    {
        return new ApiException(401, $message, $data);
    }
}
