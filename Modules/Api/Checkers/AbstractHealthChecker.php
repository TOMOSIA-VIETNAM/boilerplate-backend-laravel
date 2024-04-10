<?php

namespace Modules\Api\Checkers;

use Modules\Api\Contracts\Services\HealthChecker;

abstract class AbstractHealthChecker implements HealthChecker
{
    public function name(): string
    {
        $classname = static::class;
        return (substr($classname, strrpos($classname, '\\') + 1));
    }
}
