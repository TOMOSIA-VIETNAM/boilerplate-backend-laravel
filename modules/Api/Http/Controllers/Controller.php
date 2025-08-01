<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Api\Traits\ApiResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;
} 