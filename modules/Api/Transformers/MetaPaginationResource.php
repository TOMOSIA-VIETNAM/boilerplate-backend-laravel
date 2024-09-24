<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MetaPaginationResource extends JsonResource
{
    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * @var array|null
     */
    public $errors;

    /**
     * @var array|null
     */
    public $pagination;


    /**
     * MetaResource constructor.
     * @param int $code
     * @param string $message
     * @param null $errors
     * @param array|null $pagination
     */
    public function __construct(int $code, string $message, $errors = null, ?array $pagination = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->pagination = $pagination;
        $this->errors = $errors;
        parent::__construct($errors);
    }

    /**
     * @param mixed $request
     * @param int $code
     * @param string $message
     * @param null $errors
     * @param null $pagination
     * @return array
     */
    public static function makeResponse($request, int $code, string $message, $errors = null, $pagination = null): array
    {
        $meta = new MetaPaginationResource($code, $message, $errors, $pagination);
        return $meta->toArray($request);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $arr = [
            "code" => $this->code,
            "message" => $this->message,
        ];

        if ($this->errors !== null) {
            $arr['errors'] = $this->errors;
        }

        if ($this->pagination !== null) {
            $arr['pagination'] = $this->pagination;
        }

        return $arr;
    }
}
